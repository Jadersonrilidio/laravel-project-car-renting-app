<?php

namespace App\Http\Controllers;

use App\Models\CarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Repositories\CarModelRepository;
use App\Http\Controllers\Traits\RewriteModelAttributess;
use App\Http\Controllers\Traits\StandardStorage;
use App\Http\Controllers\Traits\ErrorResponses;

class CarModelController extends Controller
{
    use RewriteModelAttributess, StandardStorage, ErrorResponses;

    /**
     * CarModel instance.
     * 
     * @var App\Models\CarModel
     */
    public $carModel;

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
        'path'  => 'images/car-models',
        'disk'  => 'public',
    );

    /**
     * CarModelController constructor (magic method)
     */
    public function __construct(CarModel $carModel)
    {
        $this->carModel = $carModel;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = $request->get('filter');
        $attr = $request->get('attr');
        $attr_brand = $request->get('attr_brand') ? ('brand:id,' . $request->get('attr_brand')) : 'brand';

        $carModelRepository = new CarModelRepository($this->carModel);

        if ($filter)
            $carModelRepository->filterRegistersFromModel($filter);

        if ($attr)
            $carModelRepository->selectAttributesFromModel($attr);

        if (str_contains($attr, 'brand_id'))
            $carModelRepository->selectAttributesForRelationalEntity($attr_brand);

        $carModels = $carModelRepository->getModelCollection();

        return response()->json($carModels, 200, $this->headerOptions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->carModel->rules(), $this->carModel->feedback());

        $image_urn = $this->storeImage($request, $this->storageVars);

        $inputs = array_merge($request->all(), ['image' => $image_urn]);

        $newCarModel = $this->carModel->create($inputs);

        return response()->json($newCarModel, 201, $this->headerOptions);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $carModel = $this->carModel->with('brand')->find($id);

        return ($carModel)
            ? response()->json($carModel, 200, $this->headerOptions)
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
        $carModel = $this->carModel->find($id);

        if ($carModel === null)
            return $this->errorResponse();

        $rules = $this->rewriteRules($request, $carModel);

        $request->validate($rules, $carModel->feedback());

        if ($rules['image'])
            Storage::disk('public')->delete($carModel->image);

        $carModel->fill($request->all());

        if ($rules['image'])
            $carModel->image = $this->storeImage($request, $this->storageVars);

        $carModel->save();

        return response()->json($carModel, 200, $this->headerOptions);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\CarModel  $carModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarModel $carModel)
    {
        if ($carModel === null)
            return $this->errorResponse();

        $deletedCarModel = $carModel;

        Storage::disk('public')->delete($carModel->image);
        $carModel->delete();

        return response()->json($deletedCarModel, 200, $this->headerOptions);
    }
}
