<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Repositories\BrandRepository;
use App\Http\Controllers\Traits\RewriteModelAttributess;
use App\Http\Controllers\Traits\StandardStorage;
use App\Http\Controllers\Traits\ErrorResponses;

class BrandController extends Controller
{
    use RewriteModelAttributess, StandardStorage, ErrorResponses;

    /**
     * Brand object instance injection model.
     * 
     * @var App\Models\Brand
     */
    protected $brand;

    /**
     * Response header options associative array
     * 
     * @var array
     */
    protected $headerOptions = array(
        'Content-Type' => 'application/json',
    );

    /**
     * Array containing image storage variables.
     * 
     */
    protected $storageVars = array(
        'input' => 'image',
        'path'  => 'images/brands',
        'disk'  => 'public',
    );

    /**
     * BrandController constructor's magic method.
     */
    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = $request->get('filter');
        $attr = $request->get('attr');
        $attr_models = $request->get('attr_models') ? ('carModels:brand_id,' . $request->get('attr_models')) : 'carModels';

        $brandRepository = new BrandRepository($this->brand);

        if ($filter)
            $brandRepository->filterRegistersFromModel($filter);

        if ($attr)
            $brandRepository->selectAttributesFromModel($attr);

        $brandRepository->selectAttributesForRelationalEntity($attr_models);

        $brands = $brandRepository->getModelCollection();

        return response()->json($brands, 200, $this->headerOptions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->brand->rules(), $this->brand->feedback());

        $image_urn = $this->storeImage($request, $this->storageVars);

        $input = array_merge($request->all(), ['image' => $image_urn]);

        $newBrand = $this->brand->create($input);

        return response()->json($newBrand, 201, $this->headerOptions);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer  $brand
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $brand = $this->brand->with('carModels')->find($id);

        return ($brand)
            ? response()->json($brand, 200, $this->headerOptions)
            : $this->errorResponse();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $brand = $this->brand->find($id);

        if ($brand === null)
            return $this->errorResponse();

        $rules = $this->rewriteRules($request, $brand);

        $request->validate($rules, $brand->feedback());

        if ($rules['image'])
            Storage::disk('public')->delete($brand->image);

        $brand->fill($request->all());

        if ($rules['image'])
            $brand->image = $this->storeImage($request, $this->storageVars);

        $brand->save();

        return response()->json($brand, 200, $this->headerOptions);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = $this->brand->find($id);

        if ($brand === null)
            return $this->errorResponse();

        $deletedBrand = $brand;

        Storage::disk('public')->delete($brand->image);
        $brand->delete();

        return response()->json($deletedBrand, 200, $this->headerOptions);
    }
}
