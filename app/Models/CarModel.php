<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'car_models';

    /**
     * Table columns allowed to fill with mass assignment
     * 
     * @var string
     */
    protected $fillable = ['brand_id', 'name', 'image', 'num_doors', 'num_passengers', 'air_bag', 'abs'];

    /**
     * Stablish relationship between table brands.
     */
    public function brand()
    {
        return $this->hasOne(App\Models\Brand::class, 'brand_id', 'id');
    }

    /**
     * Stablish relationship between table cars.
     */
    public function cars()
    {
        return $this->hasMany(App\Models\Car::class, 'car_model_id', 'id');
    }

}
