<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use Intervention\Image\Facades\Image;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $batas = 5;        
        $jumlahData = Buku::count(); // Mendapatkan jumlah data
        $data_buku = Buku::orderBy('id', 'desc')->paginate($batas);
        $totalHarga = Buku::sum('harga');
        $no = $batas * ($data_buku->currentPage() - 1);
        return view('dashboard', compact('data_buku', 'jumlahData','totalHarga', 'no'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('buku.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'judul'  => 'required|string',
            'penulis'   => 'required|string|max:30',
            'harga'  => 'required|numeric',
            'tgl_terbit' => 'required|date'
        ]);
        
        $request->validate([
            'thumbnail' => 'image|mimes:jpeg,jpg,png|max:2048'
        ]);

        $fileName = time().'_'.$request->thumbnail->getClientOriginalName();
        $filePath = $request->file('thumbnail')->storeAs('uploads', $fileName, 'public');

        Image::make(storage_path().'/app/public/uploads/'.$fileName)->fit(120,160)->save();

        Buku::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'harga' => $request->harga,
            'tgl_terbit' => $request->tgl_terbit,
            'filename' => $request,
            'filepath' => '/storage/' . $filePath
        ]);

        if ($request->file('gallery')) {
            foreach($request->file('gallery') as $key => $file){
                $fileName = time().'_'.$request->thumbnail->getClientOriginalName();
                $filePath = $request->file('thumbnail')->storeAs('uploads', $fileName, 'public');

                $gallery = Gallery::create([
                    'nama_galeri'   => $fileName,
                    'path'          => '/storage/' . $filePath,
                    'foto'          => $fileName,
                    'buku_id'       => $id
                ]);
            }
        }

        return redirect('/buku')->with('pesan','Data Buku Berhasil di Simpan');
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
        $buku = Buku::find($id);
        return view('buku.edit', compact('buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $buku = Buku::find($id);

        $request->validate([
            'thumbnail' => 'image|mimes:jpeg,jpg,png|max:2048'
        ]);

        $fileName = time().'_'.$request->thumbnail->getClientOriginalName();
        $filePath = $request->file('thumbnail')->storeAs('uploads', $fileName, 'public');

        Image::make(storage_path().'/app/public/uploads/'.$fileName)->fit(120,160)->save();

        $buku->update([
            'judul'         => $request->judul,
            'penulis'       => $request->penulis,
            'harga'         => $request->harga,
            'tgl_terbit'    => $request->tgl_terbit,
            'filename'      => $fileName,
            'filepath'      => '/storage/' . $filePath
        ]);

        return redirect('/buku')->with('pesan','Data Buku Berhasil di Update');

        if ($request->file('gallery')) {
            foreach($request->file('gallery') as $key => $file){
                $fileName = time().'_'.$request->thumbnail->getClientOriginalName();
                $filePath = $request->file('thumbnail')->storeAs('uploads', $fileName, 'public');

                $gallery = Gallery::create([
                    'nama_galeri'   => $fileName,
                    'path'          => '/storage/' . $filePath,
                    'foto'          => $fileName,
                    'buku_id'       => $id
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buku = Buku::find($id);
        $buku->delete();
        return redirect('/buku')->with('pesan','Data Buku Berhasil di Hapus');

    }

    public function search(Request $request)
    {
        $batas = 5; 
        $cari = $request->kata;       
        $data_buku = Buku::where('judul', 'like', '%'.$cari.'%')->orwhere('penulis', 'like', '%'.$cari.'%')->paginate($batas);
        $jumlahData = Buku::count(); // Mendapatkan jumlah data
        $no = $batas * ($data_buku->currentPage() - 1);
        return view('buku.search', compact('cari', 'data_buku', 'jumlahData', 'no'));

    }

    public function _construct(){
        $this -> middleware('auth');
    }
}
