<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'brands';

    /**
     * Table columns allowed to fill with mass assignment.
     * 
     * @var string
     */
    protected $fillable = ['name', 'image'];

    /**
     * Describe attribute rules.
     * 
     * @param  integer  $id
     * @return array
     */
    public function rules($id = null)
    {
        $uniqueId = isset($id) ? (',name,' . $id) : '';

        return array(
            'name'  => "required|unique:brands{$uniqueId}|max:30",
            'image' => 'required|max:128|mimes:png,jpeg,jpg',
        );
    }

    /**
     * Describe rules's feedback messages.
     * 
     * @return array
     */
    public function feedback()
    {
        return array(
            'required'    => 'attribute :attribute is required',
            'name.unique' => 'brand name already exists',
            'name.max'    => ':attribute must have no more than 30 characters',
            'image.max'   => ':attribute must have no more than 128 characters',
            'image.mimes' => 'invalid file extension, must be in formats PNG ou JPEG',
        );
    }

    /**
     * Stablish relationship between table car_models.
     */
    public function carModels()
    {
        return $this->hasMany(App\Models\CarModel::class, 'brandi_id', 'id');
    }
}
