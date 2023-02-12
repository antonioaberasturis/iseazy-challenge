<?php

declare(strict_types=1);

namespace Shared;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;

abstract class ApiController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct() 
    {
        $exceptionHandler = app()->make(ApiExceptionsHttpStatusCodeMapping::class);
        
        foreach($this->exceptions() as $exceptionClass => $httpCode){
            $exceptionHandler->register($exceptionClass, $httpCode);
        }
    }

    abstract protected function exceptions(): array;
}
