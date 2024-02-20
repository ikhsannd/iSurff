<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\User;
use PDF;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $currentUser = auth()->user();

        $produk = Produk::with('kategori')->where('user_id', $currentUser->id)->get();

        $kategori = Kategori::where('user_id', $currentUser->id)->get();
        $categoryList = $kategori->pluck('nama_kategori', 'id_kategori');

        return view('produk.index', compact('produk', 'categoryList'));
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
        $user = auth()->user();

        $request->validate([
            'id_kategori' => 'required',
            'kode_produk' => 'nullable',
            'nama_produk' => 'required',
            'merk' => 'required',
            'harga_beli' => 'required',
            'diskon' => 'nullable',
            'harga_jual' => 'required',
            'stok' => 'required',
            'desc' => 'required',
            'photo' => 'required|image',
        ]);

        // Set the kode_produk based on the current timestamp or any logic you prefer
        $kode_produk = 'P' . now()->format('YmdHis');

        $file = $request->file('photo');
        $fileName = $request->nama_produk . '.' . $file->getClientOriginalExtension(); // Use getClientOriginalExtension() to get the file extension
        $image = $file->storeAs('photo', $fileName, 'public');

        // Create a new Produk instance and set its attributes
        $produk = new Produk([
            'id_kategori' => $request->id_kategori,
            'kode_produk' => $kode_produk,
            'nama_produk' => $request->nama_produk,
            'merk' => $request->merk,
            'harga_beli' => $request->harga_beli,
            'diskon' => $request->diskon,
            'harga_jual' => $request->harga_jual,
            'stok' => $request->stok,
            'desc' => $request->desc,
            'photo' => $image,
        ]);

        // Associate the Produk with the authenticated user
        $produk->user()->associate($user);

        // Save the Produk instance
        $produk->save();

        return redirect()->route('produk.index')->with('message', 'Data berhasil disimpan', 200);
        // return redirect()->route('produk.index')->withErrors($validator)->withInput();
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produk = Produk::find($id);

        return response()->json($produk);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $produk = Produk::find($id);
        $request->validate([
            'id_kategori' => 'nullable',
            'kode_produk' => 'nullable',
            'nama_produk' => 'nullable',
            'merk' => 'nullable',
            'harga_beli' => 'nullable',
            'diskon' => 'nullable',
            'harga_jual' => 'nullable',
            'stok' => 'nullable',
            'desc' => 'nullable',
            'photo' => 'nullable|image',
        ]);

        $kode_produk = 'P' . now()->format('YmdHis');

        if($request->hasFile('photo')){
            if($produk->photo) {
                Storage::disk('public')->delete($produk->photo);
            }

            $file = $request->file('photo');
            $fileName = $request->nama . '.' . $file->getClientOriginalName();

            $image = $file->storeAs('photo', $fileName, 'public');

            $produk->update([
                'id_kategori' => $request->id_kategori,
                'kode_produk' => $kode_produk,
                'nama_produk' => $request->nama_produk,
                'merk' => $request->merk,
                'harga_beli' => $request->harga_beli,
                'diskon' => $request->diskon,
                'harga_jual' => $request->harga_jual,
                'stok' => $request->stok,
                'desc' => $request->desc,
                'photo' => $image,
            ]);
        }else{
            $produk->update([
                'id_kategori' => $request->id_kategori,
                'kode_produk' => $kode_produk,
                'nama_produk' => $request->nama_produk,
                'merk' => $request->merk,
                'harga_beli' => $request->harga_beli,
                'diskon' => $request->diskon,
                'harga_jual' => $request->harga_jual,
                'stok' => $request->stok,
                'desc' => $request->desc,
            ]);
        }
        // $produk->update($request->all());

        return redirect()->route('produk.index')->with('message', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produk = Produk::find($id);
        $produk->delete();

        return redirect()->route('produk.index')->with('message', 'berhasil menghapus produk');
    }

    public function deleteSelected(Request $request)
    {
        foreach ($request->id_produk as $id) {
            $produk = Produk::find($id);
            $produk->delete();
        }

        return response(null, 204);
    }

    public function cetakBarcode(Request $request)
    {
        $dataproduk = array();
        foreach ($request->id_produk as $id) {
            $produk = Produk::find($id);
            $dataproduk[] = $produk;
        }

        $no  = 1;
        $pdf = PDF::loadView('produk.barcode', compact('dataproduk', 'no'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('produk.pdf');
    }
}
