<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use App\Repositories\ClientRepository;
use App\Http\Controllers\Traits\RewriteModelAttributess;
use App\Http\Controllers\Traits\StandardStorage;
use App\Http\Controllers\Traits\ErrorResponses;

class ClientController extends Controller
{
    use RewriteModelAttributess, StandardStorage, ErrorResponses;

    /**
     * Client instance object.
     * 
     * @var App\Models\Client
     */
    protected $client;

    /**
     * HTTP headers
     */
    protected $headerOptions = array(
        'Content-Type' => 'application/json',
    );

    /**
     * ClientController class constructor.
     * 
     * @param  App\Models\Client  $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Illuminate\Http\Requests\StoreClientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(StoreClientRequest $request)
    {
        $filter = $request->get('filter');
        $attr = $request->get('attr');
        $attr_rel = $request->get('attr_rel') ? ('rentals:client_id,' . $request->get('attr_rel')) : 'rentals';

        $clientRepository = new ClientRepository($this->client);

        if ($filter)
            $clientRepository->filterRegistersFromModel($filter);

        if ($attr)
            $clientRepository->selectAttributesFromModel($attr);

        if ($attr_rel)
            $clientRepository->selectAttributesForRelationalEntity($attr_rel);

        $clients = $clientRepository->getModelCollection();

        return response()->json($clients, 200, $this->headerOptions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreClientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClientRequest $request)
    {
        $request->validate($this->client->rules(), $this->client->feedback());

        $newClient = $this->client->create($request->all());

        return response()->json($newClient, 201, $this->headerOptions);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return ($client === null)
            ? $this->errorResponse()
            : response()->json($client, 200, $this->headerOptions);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateClientRequest  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        if ($client === null)
            return $this->errorResponse();

        $rules = $this->rewriteRules($request, $client);

        $request->validate($rules, $client->feedback());

        $client->fill($request->all());
        $client->save();

        return response()->json($client, 200, $this->headerOptions);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        if ($client === null)
            return $this->errorResponse();

        $deletedClient = $client;
        $client->delete();

        return response()->json($deletedClient, 200, $this->headerOptions);
    }
}
