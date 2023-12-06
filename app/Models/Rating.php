<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'review_ratings';
    protected $fillable = ['id', 'star_rating', 'user', 'buku_id'];

    public function buku(): BelongsTo {
        return $this->belongsTo(Buku::Class);
    }
}
