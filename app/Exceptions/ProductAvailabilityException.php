<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductAvailabilityException extends Exception
{
    /**
     * Redirects back to cart with error message
     * @return Response
     */
    public function render($request)
    {
        return redirect()->route('cart.index')->with('error_message', $this->getMessage());
    }
}
