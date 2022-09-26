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
     * Describe attribute rules.
     * 
     * @return array
     */
    public function rules()
    {
        return array(
            'car_model_id' => 'required|exists:car_models,id',
            'plate'        => "required|unique:cars,plate,{$this->id}|min:10|max:10",
            'available'    => 'required|bool',
            'km'           => 'required|integer',
        );
    }

    /**
     * Describe rules's feedback messages.
     * 
     * @return array
     */
    public function feedback()
    {
        return array();
    }

    /**
     * Stablish relationship between table car_models.
     */
    public function carModel()
    {
        return $this->belongsTo('App\Models\CarModel', 'car_model_id', 'id');
    }

    /**
     * Stablish relationship between table rentals.
     */
    public function rentals()
    {
        return $this->hasMany('App\Models\Rental', 'car_id', 'id');
    }
}
