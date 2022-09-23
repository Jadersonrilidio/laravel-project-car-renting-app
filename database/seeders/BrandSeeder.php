<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Collection of all basic brands to populate database.
     * 
     * @var array
     */
    protected $base_brands = [
        array(
            'name'  => 'Chevrolet',
            'image' => '',
        ),
        array(
            'name'  => 'Volkswagen',
            'image' => '',
        ),
        array(
            'name'  => 'Fiat',
            'image' => '',
        ),
        array(
            'name'  => 'Peugeout',
            'image' => '',
        ),
        array(
            'name'  => 'Nissan',
            'image' => '',
        ),
        array(
            'name'  => 'Tesla',
            'image' => '',
        ),
        array(
            'name'  => 'BMW',
            'image' => '',
        ),
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Brand::all()->first())
            foreach($this->base_brands as $brand)
                Brand::create($brand);
    }
}
