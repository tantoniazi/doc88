<?php


namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Model\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PedidoController extends Controller
{
    public function __construct(Pedido $model)
    {
        $this->model  = $model;
    }

    /**
     *
     * @OA\Get(
     *      path="/api/v1/cliente/{cliente_id}/pedido",
     *      operationId="api.v1.cliente/pedido.index",
     *      tags={"pedido"},
     *      summary="recuperar lista de pedido",
     *      description="recuperar lista de pedido",
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
     *      path="/api/v1/cliente/{cliente_id}/pedido/{id}",
     *      operationId="api.v1.cliente.pedido.show",
     *      tags={"cliente/pedido"},
     *      summary="recuperar lista de pedido",
     *      description="recuperar lista de pedido",
     *      @OA\Parameter(
     *          name="id",
     *          description="id do pedido",
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

    public function show(Request $request , $cliente_id , $id)
    {
        try {
            $request->request->add(
                ['id' => $id]
            );
            Validator::make($request->all(), [
                'id' => 'required|string'
            ])->validate();

            $row = $this->model->get([
                'cliente_id' => $cliente_id , 
                'id' => $id
            ]);
            return $row;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}
