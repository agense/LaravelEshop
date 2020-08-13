<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ModelModificationException extends Exception
{
    /**
     * Redirect back with input and error message
     * @return Response
     */
    public function render($request)
    {
        return back()->withInput()->with('error_message', $this->getMessage());
    }
}
