<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Stok;
use Illuminate\Http\Request;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentUser = auth()->user();
        $produk = Produk::where('user_id', $currentUser->id)->get();
        $categoryList = $produk->pluck('nama_produk', 'id');
        $stok = Stok::where('user_id', $currentUser->id)->get();
        return view('stok.index', compact('stok','categoryList'));
    }

    // public function data()
    // {
    //     $kategori = Kategori::orderBy('id_kategori', 'desc')->get();

    //     return datatables()
    //         ->of($kategori)
    //         ->addIndexColumn()
    //         ->addColumn('aksi', function ($kategori) {
    //             return '
    //             <div class="btn-group">
    //                 <button onclick="editForm(`'. route('kategori.update', $kategori->id_kategori) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
    //                 <button onclick="deleteData(`'. route('kategori.destroy', $kategori->id_kategori) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
    //             </div>
    //             ';
    //         })
    //         ->rawColumns(['aksi'])
    //         ->make(true);
    // }

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
            'produk_id' => 'required',
            'stok_masuk' => 'required|integer',
            'tanggal' => 'required',
            'keterangan' => 'required',
        ]);

        $kategori = new Stok([
            'produk_id' => $request->produk_id,
            'stok_masuk' => $request->stok_masuk,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'user_id' => $user
        ]);

        $kategori->user()->associate($user);

        $kategori->save();

        return redirect()->route('stok.index')->with('message', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stok = Stok::find($id);

        return response()->json($stok);
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
        $stok = Stok::find($id);
        $request->validate([
            'produk_id' => 'required',
            'stok_masuk' => 'required|integer',
            'tanggal' => 'required',
            'keterangan' => 'required',
        ]);
        $stok->update([
            'produk_id' => $request->produk_id,
            'stok_masuk' => $request->stok_masuk,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('stok.index')->with('message', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stok = Stok::find($id);
        $stok->delete();

        return redirect()->route('stok.index')->with('message', 'Data berhasil dihapus');
    }

    public function delete($id)
    {
        Stok::destroy($id);
        return redirect()->route('stok')->with('message', 'Data Berhasil Di Hapus Galery');
    }
}
