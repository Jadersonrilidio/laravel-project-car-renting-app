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
    protected $fillable = [
        'client_id',
        'car_id',
        'date_withdrawal',
        'date_return_expected',
        'date_return_realized',
        'daily_rate',
        'km_withdrawal',
        'km_return'
    ];

    /**
     * Describe attribute rules.
     * 
     * @return array
     */
    public function rules()
    {   
        return array(
            'client_id'            => 'required|exists:clients,id',
            'car_id'               => 'required|exists:cars,id',
            'date_withdrawal'      => 'required|date_format:Y-m-d',
            'date_return_expected' => 'required|date',
            'date_return_realized' => 'required|date',
            'daily_rate'           => 'required|numeric',
            'km_withdrawal'        => 'required|integer',
            'km_return'            => 'required|integer'
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
     * Stablish relationship between table clients.
     */
    public function client()
    {
        return $this->belongsTo('App\Models\Client', 'client_id', 'id');
    }

    /**
     * Stablish relationship between table cars.
     */
    public function car()
    {
        return $this->belongsTo('App\Models\Car', 'car_id', 'id');
    }
}
