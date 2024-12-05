<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Route;
use App\Models\Attraction;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'attraction_id',
        'route_id'
    ];

    public function attraction()
    {
        return $this->belongsTo(Attraction::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }
}
