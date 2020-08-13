<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UnrecoverableOrderFailureException extends Exception
{
    /**
     * Return to order failure route
     * @return Response
     */
    public function render($request)
    {
        return redirect()->route('checkout.failure')
        ->withErrors($this->getMessage())
        ->with('error_message', $this->getMessage());
    }
}
