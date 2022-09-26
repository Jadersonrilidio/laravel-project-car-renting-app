<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

/* 
|--------------------------------------------------------------------------
| Helper Controller Functions
|--------------------------------------------------------------------------
|
| A collection of private functions for reusable code 
| inside all sorts of Controller classes.
|
*/

trait FrequentlyUsedControllerFunctions
{
    /**
     * Return a standard Response object with httpCode and error message embeed.
     * 
     * @param  string  $errorMsg
     * @param  integer  $httpCode
     * @return Illuminate\Http\Response
     */
    function errorResponse($errorMsg = 'Resource not found', $httpCode = 404, $headerOptions = [])
    {
        return response()
            ->json(['error' => $errorMsg], $httpCode, $headerOptions);
    }

    /**
     * Image storage handler to standardize and facilitate storage.
     * 
     * @param  Illuminate\Http\Request  $request
     * @param  array  @vars
     * @return string|bool
     */
    function storeImage(Request $request, array $vars = ['input' => 'image', 'path' => 'images', 'disk' => 'public'])
    {
        extract($vars);
        
        return $request
            ->file($input)
            ->store($path, $disk);
    }

    /**
     * Rewrite the model rules.
     * 
     * @param  Illuminate\Http\Request  $request
     * @param  Illuminate\Database\Eloquent\Model  $carModel
     * @return array
     */
    private function rewriteRules(Request $request, Model $model)
    {
        if ($request->method() === 'PATCH') {
            $rewriteRules = [];

            foreach ($model->rules() as $input => $rule)
                if (array_key_exists($input, $request->all()))
                    $rewriteRules[$input] = $rule;

            return $rewriteRules;
        }

        return $model->rules();
    }
}
