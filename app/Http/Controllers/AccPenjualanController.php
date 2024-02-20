<?php

namespace App\Http\Controllers;

use App\Models\AccPenjualan;
use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccPenjualanController extends Controller
{
    public function __construct()
    {
        \Midtrans\Config::$serverKey    = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized  = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds        = config('services.midtrans.is3ds');
    }

    public function add(Request $request, $id)
    {
        $cartItem = Keranjang::findOrFail($id);
        $user = auth()->user();

        if ($request->tipe_pembayaran == 'Online') {
            $order = AccPenjualan::create([
                'user_id' => auth()->id(),
                'produk_id' => $cartItem->produk_id,
                'status' => 'Menunggu',
                'jumlah' => $cartItem->stok,
                'pesan' => 'Beli',
                'ongkir' => 12000,
                'tipe_pembayaran' => 'Online',
                'status_pembayaran' => 'Belum Dibayar',
                'total_bayar' => ($cartItem->produk->harga_jual * $cartItem->stok) + 12000,
            ]);

            $payload = [
                'transaction_details' => [
                    'order_id' => $order->id,
                    'gross_amount' => $order->total_bayar,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email'      => $user->email,
                ],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($payload);
            $order->snap_token = $snapToken;
            $this->response['snap_token'] = $snapToken;
            $order->save();

            $cartItem->delete();

            return response()->json([
                'status'     => 'success',
                'snap_token' => $this->response,
                'message' => 'Order berhasil dibuat'
            ]);
        } elseif ($request->tipe_pembayaran == 'Cash') {
            AccPenjualan::create([
                'user_id' => auth()->id(),
                'produk_id' => $cartItem->produk_id,
                'status' => 'Menunggu',
                'jumlah' => $cartItem->stok,
                'pesan' => 'Beli',
                'ongkir' => 12000,
                'tipe_pembayaran' => 'Cash',
                'status_pembayaran' => 'Dibayar',
                'total_bayar' => ($cartItem->produk->harga_jual * $cartItem->stok) + 12000,
            ]);
            $cartItem->delete();
        }


        return redirect()->route('front.pesanan')->with('message', 'Berhasil Checkout Barang');
    }

    public function callback(Request $request)
    {
        $serverKey = config('services.midtrans.serverKey');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                $order = AccPenjualan::where('id', $request->order_id)->first();
                $order->update(['status_pembayaran' => 'Dibayar']);
            }
        }
    }

    public function index(Request $request)
    {

        $userId = Auth::id();

        $data = AccPenjualan::whereHas('produk', function ($q) use ($request, $userId) {
            $q->where('nama_produk', 'LIKE', '%' . $request->search . '%')
                ->where('user_id', $userId); // Menambahkan kondisi untuk memastikan hanya produk milik user yang login
        })
            ->orderBy('id', 'desc')
            ->get();

        return view('accpenjualan.index', compact('data'));
    }
    public function Update(Request $request, $id)
    {
        $penjualan = AccPenjualan::find($id);

        if ($penjualan->jumlah > $penjualan->produk->stok) {
            return redirect()->route('accpenjualan')->with('error', 'Stok tidak cukup untuk memproses pesanan.');
        }

        $penjualan->status = 'Terkirim';
        $penjualan->save();

        $produk = $penjualan->produk;
        $produk->stok -= $penjualan->jumlah;
        $produk->save();

        return redirect()->route('accpenjualan')->with('message', 'Berhasil Memperbarui Data');
    }

    public function Delete($id)
    {
        $data = AccPenjualan::find($id);
        if ($data->items()->exists()) {
            return redirect()->route('accpenjualan')->with('error', 'kategori masih memiliki relasi');
        };
        $data->delete($id);
        return redirect()->route('accpenjualan')->with('message', 'Berhasil Menghapus Data');
    }
    public function Send(Request $request, $id)
    {
        $user_id = auth()->user()->id;

        $request->validate([
            'pesan' => 'nullable',
            'jumlah' => 'required',

        ]);

        $produk = Produk::findOrFail($id);

        $total_bayar = $request->jumlah * $produk->harga_jual;

        $accPenjualan = new AccPenjualan([
            'user_id' => $user_id,
            'produk_id' => $id,
            'status' => 'Menunggu',
            'pesan' => $request->pesan,
            'jumlah' => $request->jumlah,
            'total_bayar' => $total_bayar,
        ]);

        $accPenjualan->save();
        return redirect()->route('front.pesanan')->with('message', 'Berhasil Checkout Barang');
    }
}
