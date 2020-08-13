<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FilteringException extends Exception
{
    /**
     * Redirect to the current url without filter query
     * @return Response
     */
    public function render($request)
    {
        return redirect($request->url())->with('error_message', $this->getMessage());
    }
}
