<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggleFavorite(Buku $book)
    {
        $user = Auth::user();

        if ($user->buku->contains($book)) {
            $book->removeFromFavorites($user);
        } else {
            $book->addToFavorites($user);
        }

        return redirect()->back()->with('flash_msg_success', 'Buku berhasil diubah pada daftar favorit.');
    }
}
