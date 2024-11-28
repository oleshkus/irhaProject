<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attraction extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'address',
        'country',
        'city',
        'street',
        'latitude',
        'longitude'
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(AttractionCategory::class, 'attraction_category')
                    ->withTimestamps();
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }
}
