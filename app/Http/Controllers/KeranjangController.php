<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Produk;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Keranjang  $keranjang
     * @return \Illuminate\Http\Response
     */
    public function show(Keranjang $keranjang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Keranjang  $keranjang
     * @return \Illuminate\Http\Response
     */
    public function edit(Keranjang $keranjang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Keranjang  $keranjang
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Keranjang  $keranjang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Keranjang $cartItem)
    {
        // Check if the authenticated user is the owner of the cart item
        if ($cartItem->user_id !== auth()->id()) {
            abort(403, 'Unauthorized'); // Or redirect to an error page
        }

        // Delete the cart item
        $cartItem->delete();

        // Optionally, you may redirect to a specific page after deletion
        return redirect()->route('front.cart')->with('success', 'Item deleted successfully');
    }
    public function updatecart(Request $request, $id)
    {
        $request->validate([
            'stok' => 'required|numeric|min:1',
        ]);

        $cartItem = Keranjang::findOrFail($id);

        $cartItem->stok = $request->input('stok');
        $cartItem->save();

        return redirect()->back()->with('success', 'Cart item updated successfully');
    }
    public function addcart($id)
    {
        // Check if the product exists before trying to find it
        $product = Produk::find($id);
        $setting = Setting::first();
        if (!$product) {
            // Handle the case where the product is not found, for example, redirect to an error page or show an error message.
            return redirect()->route('front.cart')->with('error', 'Product not found');
        }


        // Check if the product is already in the user's cart
        $existingCartItem = Keranjang::where('produk_id', $product->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingCartItem) {
            // If the product is already in the cart, update the quantity or other attributes as needed
            $existingCartItem->stok += 1;
            $existingCartItem->save();
        } else {
            // If the product is not in the cart, add a new item to the cart
            Keranjang::create([
                'produk_id' => $product->id,
                'stok' => 1,
                'user_id' => auth()->id(),
                'total_harga' => null,
                // Add other attributes as needed
            ]);
        }

        return redirect()->back();
    }

}
