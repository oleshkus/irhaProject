<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AttractionCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    public function attractions(): BelongsToMany
    {
        return $this->belongsToMany(Attraction::class, 'attraction_category')
                    ->withTimestamps();
    }
}
