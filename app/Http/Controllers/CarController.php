<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Car;
use Illuminate\Http\Request;
use App\Repositories\CarRepository;
use App\Http\Controllers\Traits\RewriteModelAttributess;
use App\Http\Controllers\Traits\StandardStorage;
use App\Http\Controllers\Traits\ErrorResponses;

class CarController extends Controller
{
    use RewriteModelAttributess, StandardStorage, ErrorResponses;

    /**
     * Instance model.
     * 
     * @var App\Models\Car
     */
    protected $car;

    /**
     * Response header options associative array
     * 
     * @var array
     */
    protected $headerOptions = array(
        'Content-Type' => 'application/json',
    );

    /**
     * CarController class constructor.
     * 
     * @param  App\Models\Car  $car
     */
    public function __construct(Car $car)
    {
        $this->car = $car;
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
        $attr_rel = $request->get('attr_rel') ? ('carModel:id,'.$request->get('attr_rel')) : 'carModel';

        $carRepository = new CarRepository($this->car);

        if ($filter)
            $carRepository->filterRegistersFromModel($filter);

        if ($attr)
            $carRepository->selectAttributesFromModel($attr);

        if (str_contains($attr, 'car_model_id'))
            $carRepository->selectAttributesForRelationalEntity($attr_rel);

        $cars = $carRepository->getModelCollection();

        return response()->json($cars, 200, $this->headerOptions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCarRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCarRequest $request)
    {
        $request->validate($this->car->rules(), $this->car->feedback());

        $newCar = $this->car->create($request->all());

        return response()->json($newCar, 201, $this->headerOptions);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show(Car $car)
    {
        return ($car === null)
            ? $this->notFound()
            : response()->json($car, 200, $this->headerOptions);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCarRequest  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCarRequest $request, Car $car)
    {
        if ($car === null)
            return $this->notFound();

        $rules = $this->rewriteRules($request, $car);

        $request->validate($rules, $car->feedback());

        $car->fill($request->all());
        $car->save();

        return response()->json($car, 200, $this->headerOptions);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {
        if ($car === null)
            return $this->notFound();
        
        $deletedCar = $car;
        $car->delete();

        return response()->json($deletedCar, 200, $this->headerOptions);
    }
}
