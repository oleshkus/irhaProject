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
    
    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function getFormattedAddressAttribute(): array
    {
        $addressParts = explode(',', $this->address);
        
        // Получаем страну из первой части адреса или используем значение по умолчанию
        $country = trim($addressParts[0] ?? 'Беларусь');
        
        return [
            'location' => $country . ', ' . ($this->city ?: 'Гродно'),
            'street' => $this->street
        ];
    }
}
