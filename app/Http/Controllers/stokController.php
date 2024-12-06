<?php

namespace App\Http\Controllers;

use App\Models\stok;
use App\Models\suplier;
use Illuminate\Http\Request;

class stokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $r)
    {
        $search = $r->input('search');
        $getData = stok::with('getSuplier')
        ->where('kode_barang', 'like', "%{$search}%")
        ->orWhere('nama_barang', 'like', "%{$search}%")
        ->paginate(6);
        return view('Stok.stok', compact(
            'getData'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $getSuplier = suplier::all();
        return view('Stok.add-stok', compact(
            'getSuplier'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'suplier' => 'required',
            'cabang' => 'required', 
        ],[
            'kode_barang.required' => 'Data Wajib diisi!',
            'nama_barang.required' => 'Data Wajib diisi!',
            'harga.required' => 'Data Wajib diisi!',
            'stok.required' => 'Data Wajib diisi!',
            'suplier.required' => 'Data Wajib diisi!',
            'cabang.required' => 'Data Wajib diisi!',
        ]);

        $saveStok = new stok();
        $saveStok->kode_barang = $request->kode_barang;
        $saveStok->nama_barang = $request->nama_barang;
        $saveStok->harga = $request->harga;
        $saveStok->stok = $request->stok;
        $saveStok->suplier_id = $request->suplier;
        $saveStok->cabang = $request->cabang;
        $saveStok->save();

        return redirect('/stok')->with(
            'message',
            'Data barang ' . $request->nama_barang . ' berhasil ditambahkan'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $getDataStokId = stok::with('getSuplier')->find($id);
        $suplier = suplier::all();
        return view('Stok.edit-stok', compact(
            'getDataStokId',
            'suplier'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       $request->validate([
        'kode_barang' => 'required',
        'nama_barang' => 'required',
        'harga' => 'required',
        'stok' => 'required',
        'suplier' => 'required',
        'cabang' => 'required',
    ], [
        'kode_barang.required' => 'Data Wajib Diisi!',
        'nama_barang.required' => 'Data Wajib Diisi!',
        'harga.required' => 'Format email tidak sesuai!',       
        'stok.required' => 'Data Wajib Diisi!',       
        'suplier.required' => 'Data Wajib Diisi!',       
        'cabang.required' => 'Data Wajib Diisi!',              
    ]);

    $saveSuplier = stok::find($id);
    $saveSuplier->kode_barang = $request->kode_barang;
    $saveSuplier->nama_barang = $request->nama_barang;
    $saveSuplier->harga = $request->harga;
    $saveSuplier->stok = $request->stok;
    $saveSuplier->suplier_id = $request->suplier;
    $saveSuplier->cabang = $request->cabang;
    $saveSuplier->save();

    return redirect('/stok')->with(
        'message',
        'Data barang ' . $request->nama_barang . ' berhasil ditambahkan!!'
    );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
