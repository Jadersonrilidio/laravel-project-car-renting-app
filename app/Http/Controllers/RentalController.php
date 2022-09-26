<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRentalRequest;
use App\Http\Requests\UpdateRentalRequest;
use App\Models\Rental;
use App\Traits\FrequentlyUsedControllerFunctions;
use App\Repositories\RentalRepository;

class RentalController extends Controller
{
    use FrequentlyUsedControllerFunctions;

    /**
     * Rental instance object.
     * 
     * @var App\Models\Rental
     */
    protected $rental;

    /**
     * 
     * @var array
     */
    protected $headerOptions = array(
        'Content-Type' => 'application/json',
    );

    /**
     * RentalController class constructor.
     * 
     * @param App\Models\Rental
     */
    public function __construct(Rental $rental)
    {
        $this->rental = $rental;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Illuminate\Http\Requests\StoreRentalRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(StoreRentalRequest $request)
    {
        $filter = $request->get('filter');
        $attr = $request->get('attr');
        $attr_car = $request->get('attr_car') ? ('car:car_id,' . $request->get('attr_car')) : 'car';
        $attr_client = $request->get('attr_client') ? ('client:client_id,' . $request->get('attr_client')) : 'client';

        $rentalRepository = new RentalRepository($this->rental);

        if ($filter)
            $rentalRepository->filterRegistersFromModel($filter);

        if ($attr)
            $rentalRepository->selectAttributesFromModel($attr);

        if (str_contains($attr, 'car_id'))
            $rentalRepository->selectAttributesForRelationalEntity($attr_car);

        if (str_contains($attr, 'client_id'))
            $rentalRepository->selectAttributesForRelationalEntity($attr_client);

        $rentals = $rentalRepository->getModelCollection();

        return response()->json($rentals, 200, $this->headerOptions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRentalRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRentalRequest $request)
    {
        $request->validate($this->rental->rules(), $this->rental->feedback());

        $newRental = $this->rental->create($request->all());

        return response()->json($newRental, 201, $this->headerOptions);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rental  $rental
     * @return \Illuminate\Http\Response
     */
    public function show(Rental $rental)
    {
        return ($rental === null)
            ? $this->errorResponse()
            : response()->json($rental, 200, $this->headerOptions);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRentalRequest  $request
     * @param  \App\Models\Rental  $rental
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRentalRequest $request, Rental $rental)
    {
        if ($rental === null)
            return $this->errorResponse();

        $rules = $this->rewriteRules($request, $rental);

        $request->validate($rules, $rental->feedback);

        $rental->fill($request->all());
        $rental->save();

        return response()->json($rental, 200, $this->headerOptions);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rental  $rental
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rental $rental)
    {
        if ($rental === null)
            return $this->errorResponse();

        $deletedRental = $rental;
        $rental->delete();

        return response()->json($deletedRental, 200, $this->headerOptions);
    }
}
