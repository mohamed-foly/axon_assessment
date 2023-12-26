<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';

    /**
     * Scope a query to filter customers by country name.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $countryName
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterByCountry($query, $countryName)
    {
        if ($countryName) {
            $countries = collect(config('countries'));
            $searchCountry = $countries->firstWhere('name', $countryName);

            if ($searchCountry) {
                $countryCode = '(' . str_replace('+', '', Arr::get($searchCountry, 'code')) . ')';
                return $query->where('phone', 'LIKE', "{$countryCode}%");
            }
        }

        return $query;
    }
}
