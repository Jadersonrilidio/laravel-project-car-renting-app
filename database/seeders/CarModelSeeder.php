<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarModel;

class CarModelSeeder extends Seeder
{
    /**
     * Collection of car models to populate the database.
     * 
     * @var array
     */
    protected $base_carModels = [
        array(
            'brand_id'       => 1,
            'name'           => 'Marajo',
            'image'          => '',
            'num_doors'      => 2,
            'num_passengers' => 5,
            'km'             => 0,
            'air_bag'        => false,
            'abs'            => false,
        ),
        array(
            'brand_id'       => 2,
            'name'           => 'Marajo',
            'image'          => '',
            'num_doors'      => 2,
            'num_passengers' => 5,
            'km'             => 0,
            'air_bag'        => false,
            'abs'            => false,
        ),
        array(
            'brand_id'       => 3,
            'name'           => 'Marajo',
            'image'          => '',
            'num_doors'      => 2,
            'num_passengers' => 5,
            'km'             => 0,
            'air_bag'        => false,
            'abs'            => false,
        ),
        array(
            'brand_id'       => 4,
            'name'           => 'Marajo',
            'image'          => '',
            'num_doors'      => 2,
            'num_passengers' => 5,
            'km'             => 0,
            'air_bag'        => false,
            'abs'            => false,
        ),
        array(
            'brand_id'       => 5,
            'name'           => 'Marajo',
            'image'          => '',
            'num_doors'      => 2,
            'num_passengers' => 5,
            'km'             => 0,
            'air_bag'        => false,
            'abs'            => false,
        ),
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!CarModel::all()->first())
            foreach($this->base_carModels as $carModel)
                CarModel::create($carModel);
    }
}
