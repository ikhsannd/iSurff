<?php

namespace App\Http\Controllers;

use App\Models\AccPenjualan;
use App\Models\Keranjang;
use App\Models\Produk;
use App\Models\Setting;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class FrontController extends Controller
{
    public function index(Request $request)
    {
        $setting = Setting::first();
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');


        $produkfront = Produk::query();

        if ($minPrice && $maxPrice) {
            $produkfront->whereBetween('harga_jual', [$minPrice, $maxPrice]);
        }

        $produkfront = $produkfront->get();
        return view('front.content', compact('produkfront', 'minPrice', 'maxPrice', 'setting'));
    }
    public function cart()
    {
        $setting = Setting::first();
        $cartItems = Keranjang::where('user_id', Auth::id())->get();
        return view('front.cart', compact('cartItems', 'setting'));
    }

    public function pesanan(Request $request)
    {
        $userId = Auth::id();
        $setting = Setting::first();
        $data = AccPenjualan::where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->get();

        return view('front.pesanan', compact('data', 'setting'));
    }

    public function detailcontent($id)
    {
        $detail = Produk::find($id);
        $setting = Setting::first();
        return view('front.detailcontent', compact('detail', 'setting'));
    }

    public function wishlist()
    {
        $setting = Setting::first();
        $wishlistItem = Wishlist::where('user_id', Auth::id())->get();
        return view('front.wishlist', compact('wishlistItem', 'setting'));
    }

    public function addwishlist($id)
    {
        $data = Produk::find($id);

        $existingWishlist = Wishlist::where('produk_id', $data->id)->where('user_id', auth()->id())->first();

        if ($existingWishlist) {
            Session::flash('message', 'Item sudah ada di wishlist kamu');
        } else {
            Wishlist::create([
                'produk_id' => $data->id,
                'user_id' => auth()->id(),
            ]);
            Session::flash('message', 'Berhasil ditambahkan ke wishlist');
        }

        return redirect()->back();
    }

    public function deletewishlist(Wishlist $item)
    {
        if ($item->user_id !== auth()->id()) {
            abort(403, 'Unauthorized'); // Or redirect to an error page
        }

        $item->delete();

        return redirect()->route('wishlist.index');
    }

    public function profile()
    {
        $user = Auth::user();
        $setting = Setting::first();
        return view('front.profile', compact('user', 'setting'));
    }

    public function showorders()
    {
        $orders = AccPenjualan::with('produk')->where('user_id', auth()->id())->get();
        return view('front.order', ['orders' => $orders]);
    }

    public function catalog(Request $request)
    {
        $setting = Setting::first();
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');


        $produkfront = Produk::query();

        if ($minPrice && $maxPrice) {
            $produkfront->whereBetween('harga_jual', [$minPrice, $maxPrice]);
        }

        $produkfront = $produkfront->get();
        return view('catalog.catalogue', compact('produkfront', 'minPrice', 'maxPrice', 'setting'));
    }
    public function successPage($id)
    {
        $data = AccPenjualan::with('produk.user')->where('id', $id)->first();
        $setting = Setting::first();

        return view('catalog.successpage', compact('data', 'setting'));
    }
}
