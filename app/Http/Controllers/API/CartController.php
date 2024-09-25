<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);

        return response()->json(['message' => 'Item added to cart']);
    }

    public function delete($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();

        return response()->json(['message' => 'Item removed from cart']);
    }

    public function update(Request $request, $id)
    {
        $cartItem = CartItem::findOrFail($id);
        $request->validate(['quantity' => 'required|integer|min:1']);

        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json(['message' => 'Cart item updated']);
    }
}
