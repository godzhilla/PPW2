<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Gallery;
use App\Models\Review;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

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
        if ($request->file('thumbnail')) {
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
        }

        if ($request->hasFile('gallery')) {
            foreach($request->file('gallery') as $key => $file) {
                $fileName = time().'_'.$file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $fileName, 'public');

                Image::make(storage_path('app/public/uploads/' . $fileName));

                $gallery = Gallery::create([
                    'nama_galeri'   => $fileName,
                    'foto'          => $fileName,
                    'buku_id'       => $id,
                    'path'          => '/storage/' . $filePath,
                ]);
            }
        }

        return redirect('/buku')->with('pesan','Data Buku Berhasil di Update');

        
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

    public function deleteGalleryImage($id)
    {
        $gallery = Gallery::find($id);

        // Delete the file from storage
        Storage::delete('public/' . $gallery->path);

        // Delete the gallery record from the database
        $gallery->delete();

        return redirect()->back()->with('pesan', 'Gambar Galeri Berhasil dihapus');
    }

    public function showRating()
    {
        $data_buku = Buku::all();
        return view('buku.rating', compact('data_buku'));
    }

    public function reviewbuku(Request $request){
        // Validate the incoming request data
        $request->validate([
            'buku_id' => 'required', // Add any other validation rules you need
            'rating' => 'required|numeric|min:1|max:5', // Adjust the validation rules for the rating field
        ]);
    
        // Create a new ReviewRating instance
        $review = new Rating();
    
        // Assign values from the request to the ReviewRating instance
        $review->buku_id = $request->buku_id;
        $review->star_rating = $request->rating;
    
        // Save the review to the database
        $review->save();
    
        // Redirect back with a success message
        return redirect()->back()->with('flash_msg_success', 'Your review has been submitted successfully.');
    }


    public function showList()
    {
        $data_buku = Buku::all();
        return view('buku.list', compact('data_buku'));
    }

    public function galbuku($id) {
        $buku = Buku::find($id);
        
        return view('buku.detail', compact('buku'));
    }

    public function addToFavorite($id) {
        $user = Auth::user($id);

        if ($user) {
            $buku = Buku::find($id);

            if ($buku) {
                if ($user -> contains($buku->id)) {
                    $user->favoriteBooks()->attach($buku);

                    return redirect()->back()->with('success', 'Buku berhasil ditambahkan ke daftar favorit.');

                } else {
                    return redirect()->back()->with('error', 'Buku sudah terdapat dalam daftar favorit.');  
                }
            } else {
                return redirect()->back()->with('error', 'Buku tidak ditemukan.');
            }
        }

        return redirect()->back()->with('error', 'Buku gagal ditambahkan ke daftar favorit.');

    }

    public function topBooks()
    {
        $topBooks = Buku::orderByDesc('star_rating')->take(10)->get();

        return view('buku.top10', compact('topBooks'));
    }

    public function addRating(Request $request, $id)
    {
        $request->validate([
            'star_rating' => 'required|numeric|min:0|max:5',
        ]);
    
        $buku = Buku::find($bukuId);
        if (!$buku) {
            abort(404);
        }
    
        $buku->update([
            'star_rating' => $request->input('star_rating'),
        ]);
    
        return redirect()->route('buku.rating', compac($buku))->with('success', 'Rating added successfully.');
    }

    public function showReviews($id)
    {
        $buku = Buku::find($id);
        $reviews = $buku->reviews;

        return view('buku.reviews', compact('buku', 'reviews'));
    }

    public function storeReview(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'comment' => 'required',
        ]);

        $buku = Buku::find($id);
        if (!$buku) {
            abort(404);
        }

        $review = new Review([
            'name' => $request->input('name'),
            'comment' => $request->input('comment'),
        ]);

        $buku->reviews()->save($review);

        return redirect()->route('buku.reviews', $id)->with('success', 'Review added successfully.');
    }
    
}
