<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    
    public function __construct(Cliente $model)
    {
        $this->model  = $model;
    }

    /**
     *
     * @OA\Get(
     *      path="/api/v1/cliente",
     *      operationId="api.v1.cliente.index",
     *      tags={"cliente"},
     *      summary="recuperar lista de cliente",
     *      description="recuperar lista de cliente",
     *      @OA\Response(
     *          response=200,
     *          description="sucesso"
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="erro"
     *       )
     *     )
     */

    public function index(Request $request)
    {
        try {

            $all = $this->model->paginate(15);
            return $all;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     *
     * @OA\Get(
     *      path="/api/v1/cliente/{id}",
     *      operationId="api.v1.cliente.show",
     *      tags={"cliente"},
     *      summary="recuperar lista de cliente",
     *      description="recuperar lista de cliente",
     *      @OA\Parameter(
     *          name="id",
     *          description="id do cliente",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="sucesso"
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="erro"
     *       )
     *     )
     */

    public function show(Request $request , $id)
    {
        try {
            $request->request->add(
                ['id' => $id]
            );
            Validator::make($request->all(), [
                'id' => 'required|string'
            ])->validate();

            $row = $this->mode->find($id);
            return $row;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


}
