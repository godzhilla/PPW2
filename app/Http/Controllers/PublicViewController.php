<?php

namespace App\Http\Controllers;
use App\Models\Buku;
use Illuminate\Http\Request;

class PublicViewController extends Controller
{
    public function showList()
    {
        $data_buku = Buku::all();
        return view('buku.list', compact('data_buku'));
    }

    public function showDetail() {
        $data_buku = Buku::all();
        return view('buku.detail', compact('data_buku'));
    }
}
