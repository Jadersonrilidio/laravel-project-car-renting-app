<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rentals';

    /**
     * Table columns allowed to fill with mass assignment
     * 
     * @var string
     */
    protected $fillable = ['client_id', 'car_id', 'date_withdrawal', 'date_return_expected', 'date_return_realized', 'daily_rate', 'km_withdrawal', 'km_return'];

    /**
     * Stablish relationship between table clients.
     */
    protected function client()
    {
        return $this->hasOne(App\Models\Client::class, 'client_id', 'id');
    }

    /**
     * Stablish relationship between table cars.
     */
    protected function car()
    {
        return $this->hasOne(App\Models\Car::class, 'car_id', 'id');
    }
}
