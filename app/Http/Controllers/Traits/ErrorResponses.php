<?php

namespace App\Http\Controllers\Traits;

trait ErrorResponses
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
}
