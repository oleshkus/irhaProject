<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'attraction_id'
    ];

    public function attraction()
    {
        return $this->belongsTo(Attraction::class);
    }
}
