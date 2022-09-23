<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Brand object instance injection model.
     * 
     * @var App\Models\Brand
     */
    protected $brand;

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
    public function index()
    {
        return response()->json($this->brand->all(), 200, ['Content-Type' => 'application/json']);
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

        $image_urn = $request->file('image')->store('images', 'public');

        $newBrand = $this->brand->create(array(
            'name'  => $request->get('name'),
            'image' => $image_urn,
        ));

        return response()->json($newBrand, 201, ['Content-Type' => 'application/json']);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer  $brand
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $brand = $this->brand->find($id);

        if ($brand === null)
            return $this->errorResponse();

        return response()->json($brand, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $brand = $this->brand->find($id);

        if ($brand === null)
            return $this->errorResponse();

        $rewriteRules = $this->brand->rules($id);

        if ($request->method() === 'PATCH') {
            $rewriteRules = [];
            foreach (array_keys($request->all()) as $attr)
                $rewriteRules[$attr] = $this->brand->rules($id)[$attr];
        }

        $request->validate($rewriteRules, $this->brand->feedback());

        if(isset($rewriteRules['image'])) {
            Storage::disk('public')->delete($brand->image);
            $brand->image = $request->file('image')->store('images', 'public');
        }

        if(isset($rewriteRules['name']))
            $brand->name = $request->get('name');

        $brand->save();

        return response()->json($brand, 200, ['Content-Type' => 'application/json']);
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

        return response()->json($deletedBrand, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * Return a Response object with httpCode and error message embeed.
     * 
     * @param  string  $errorMsg
     * @param  integer  $httpCode
     * @return Illuminate\Http\Response
     */
    private function errorResponse($errorMsg = 'Resource not found', $httpCode = 404)
    {
        return response()
            ->json(['error' => $errorMsg], $httpCode, ['Content-Type' => 'application/json']);
    }

    // /**
    //  * Store an image contained on the request.
    //  * 
    //  * @param  Illuminate\Http\Request  $request
    //  * @param  string  $inputName
    //  * @param  string  $dirName
    //  * @param  string  $path
    //  * @return string|bool
    //  */
    // private function storeImage(Request $request, $inputName = 'image', $dirName = 'images', $path = 'public')
    // {
    //     return $request->file($inputName)->store($dirName, $path);
    // }
}
