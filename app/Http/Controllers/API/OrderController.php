<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
                        ->with('items.product')
                        ->get();

        if ($orders->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'no orders found',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'orders fetched',
            'data' => $orders,
            'total_orders' => $orders->count(),
        ], 200);
    }

    public function checkoutFromCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cart_id' => 'required|array',
            'cart_id.*' => 'exists:cart_items,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
                'data' => null,
            ], 422);
        }

        $cartItems = CartItem::whereIn('id', $request->cart_id)
                            ->where('user_id', Auth::id())
                            ->with('product')
                            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No items found in the cart',
                'data' => null,
            ], 404);
        }

        $totalPrice = 0;
        foreach ($cartItems as $cartItem) {
            $totalPrice += $cartItem->product->price * $cartItem->quantity;
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price,
            ]);

            $cartItem->product->decrement('stock', $cartItem->quantity);
            $cartItem->delete();
        }

        $item_details = [];
        foreach ($cartItems as $cartItem) {
            $item_details[] = [
                'id' => 'p' . $cartItem->product_id,
                'price' => (int)$cartItem->product->price,
                'quantity' => (int)$cartItem->quantity,
                'name' => $cartItem->product->name,
            ];
        }

        $params = array(
            'transaction_details' => array(
                'order_id' => $order->id,
                'gross_amount' => $totalPrice,
            ),
            'customer_details' => array(
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->phone_number,
                'address' => Auth::user()->address,
            ),
            'item_details' => $item_details,
        );

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json([
                'status' => 'success',
                'message' => 'Order placed successfully. Please proceed to payment.',
                'data' => [
                    'order' => $order,
                    'snap_token' => $snapToken,
                    'redirect_url' => 'https://app.sandbox.midtrans.com/snap/v2/vtweb/' .$snapToken,
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create payment.',
                'data' => null,
            ], 500);
        }
    }

    public function checkoutFromProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
                'data' => null,
            ], 422);
        }

        $product = Product::find($request->product_id);

        if ($product->stock < $request->quantity) {
            return response()->json([
                'status' => 'error',
                'message' => 'Insufficient stock for the selected product',
                'data' => null,
            ], 400);
        }

        $totalPrice = $product->price * $request->quantity;

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $totalPrice,
            'status' => 'completed',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $product->price,
        ]);

        $product->decrement('stock', $request->quantity);

        $params = array(
            'transaction_details' => array(
                'order_id' => $order->id,
                'gross_amount' => $totalPrice,
            ),
            'customer_details' => array(
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->phone_number,
                'address' => Auth::user()->address,
            ),
            'item_details' => array(
                'id' => 'p' . $product->id,
                'price' => (int)$product->price,
                'quantity' => (int)$product->quantity,
                'name' => $product->name,
            ),
        );

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json([
                'status' => 'success',
                'message' => 'Order placed successfully. Please proceed to payment.',
                'data' => [
                    'order' => $order,
                    'snap_token' => $snapToken,
                    'redirect_url' => 'https://app.sandbox.midtrans.com/snap/v2/vtweb/' .$snapToken,
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create payment.',
                'data' => null,
            ], 500);
        }
    }

    public function handleCallback(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        if ($hashed != $request->signature_key) {
            return response()->json(['status' => 'error', 'message' => 'Invalid signature'], 403);
        }

        $order = Order::find($request->order_id);

        if (!$order) {
            return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
        }

        if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
            $order->update(['status' => 'completed']);
        } elseif ($request->transaction_status == 'cancel' || $request->transaction_status == 'deny' || $request->transaction_status == 'expire') {
            $order->update(['status' => 'cancelled']);
        }

        $order->update([
            'transaction_id' => $request->transaction_id,
            'payment_type' => $request->payment_type,
            'va_number' => $request->va_number ?? null,
            'bank' => $request->bank ?? null,
            'acquirer' => $request->acquirer ?? null,
            'reference_no' => $request->payment_reference_no ?? null,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Order status updated']);
    }
}