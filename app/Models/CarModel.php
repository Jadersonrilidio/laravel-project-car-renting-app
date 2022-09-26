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
     * Describe attribute rules.
     * 
     * @return array
     */
    public function rules()
    {
        return array(
            'brand_id'       => 'exists:brands,id',
            'name'           => "required|unique:car_models,name,{$this->id}|max:30",
            'image'          => 'required|file|mimes:png,jpeg,jpg',
            'num_doors'      => 'required|integer|digits_between:1,8',
            'num_passengers' => 'required|integer|digits_between:1,99',
            'air_bag'        => 'required|boolean',
            'abs'            => 'required|boolean',
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
     * Stablish relationship between table brands.
     */
    public function brand()
    {
        return $this->belongsTo('App\Models\Brand', 'brand_id', 'id');
    }

    /**
     * Stablish relationship between table cars.
     */
    public function cars()
    {
        return $this->hasMany('App\Models\Car', 'car_model_id', 'id');
    }
}
