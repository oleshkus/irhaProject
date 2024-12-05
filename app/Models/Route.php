<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attraction;
use App\Models\User;
use App\Models\Image;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'image',
        'price',
        'duration'
    ];

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function attractions(): BelongsToMany
    {
        return $this->belongsToMany(Attraction::class, 'route_attraction')
            ->withPivot('order')
            ->orderBy('order');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getOrderedAttractions()
    {
        return $this->attractions()->orderBy('order')->get();
    }

    public function getDirectionsUrl()
    {
        $attractions = $this->getOrderedAttractions();
        
        if ($attractions->isEmpty()) {
            return '#';
        }

        $origin = $attractions->first();
        $destination = $attractions->last();
        $waypoints = $attractions->slice(1, -1)->map(function ($attraction) {
            return urlencode($attraction->formatted_address['location']);
        })->join('|');

        $url = "https://www.google.com/maps/dir/?api=1";
        $url .= "&origin=" . urlencode($origin->formatted_address['location']);
        $url .= "&destination=" . urlencode($destination->formatted_address['location']);
        
        if (!empty($waypoints)) {
            $url .= "&waypoints=" . $waypoints;
        }

        return $url;
    }
}
