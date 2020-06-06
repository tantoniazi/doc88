<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;



/**
 *
 * @OA\Info(
 *      version="1.0.0",
 *      title="PROVA DOC88",
 *      description="PROVA DOC88",
 *      @OA\Contact(
 *          email="tiago.antoniazi@gmail.com"
 *      )
 * ),
 *
 *  @OA\Server(
 *      url="https://localhost:8282/",
 *      description="dev"
 *  )
 * 
 */


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
