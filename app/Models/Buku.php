<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';
    protected $fillable = [
        'id', 
        'judul', 
        'penulis', 
        'harga', 
        'tgl_terbit', 
        'created_at', 
        'updated_at',
        'filename',
        'filepath'];
    protected $dates = ['tgl_terbit'];

    public function galleries(): HasMany {
        return $this->hasMany(Gallery::Class);
    }

    public function photos() {
        return $this -> hasMany('App\Buku', 'id_buku', 'id');
    }

    public function addToFavorites(User $user)
    {
        $this->users()->attach($user->id);
        $this->update(['is_favorite' => true]);
    }

    public function removeFromFavorites(User $user)
    {
        $this->users()->detach($user->id);
        $this->update(['is_favorite' => false]);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_book_favorites')->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
