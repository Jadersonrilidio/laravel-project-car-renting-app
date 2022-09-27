<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'clients';

    /**
     * Table columns allowed to fill with mass assignment
     * 
     * @var string
     */
    protected $fillable = ['name'];

    /**
     * Describe attribute rules.
     * 
     * @return array
     */
    public function rules()
    {
        return array(
            'name' => "required|min:3|max:30",
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
            'name.required' => 'attribute name is required',
            'name.min'      => 'attribute name must have between 3 and 30 characters',
            'name.max'      => 'attribute name must have between 3 and 30 characters',
        );
    }

    /**
     * Stablish relationship between table rentals.
     */
    public function rentals()
    {
        return $this->hasMany('App\Models\Rental', 'client_id', 'id');
    }
}
