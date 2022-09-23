<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cars';

    /**
     * Table columns allowed to fill with mass assignment.
     * 
     * @var string
     */
    protected $fillable = ['car_model_id', 'plate', 'available', 'km'];

    /**
     * Stablish relationship between table car_models.
     */
    public function carModels()
    {
        return $this->hasOne(App\Models\CarModel::class, 'car_model_id', 'id');
    }

    /**
     * Stablish relationship between table rentals.
     */
    public function rentals()
    {
        return $this->hasMany(App\Models\Rental::class, 'car_id', 'id');
    }
}
