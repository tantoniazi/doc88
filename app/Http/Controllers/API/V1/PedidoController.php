<?php


namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Model\Cliente;
use App\Model\Pedido;
use App\Model\PedidoXPastel as ModelPedidoXPastel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use PedidoXPastel;

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
     *      operationId="api.v1.cliente.pedido.index",
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

    public function index(Request $request, $cliente_id)
    {
        try {
            $all = $this->model->where('cliente_id', $cliente_id)->paginate(15);
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

    public function show(Request $request, $cliente_id, $id)
    {
        try {
            $request->request->add(
                [
                    'id' => $id,
                    'cliente_id' => $cliente_id
                ]
            );
            Validator::make($request->all(), [
                'id' => 'required|integer',
                'cliente_id' => 'required|integer'
            ])->validate();

            $row = $this->model->get([
                'cliente_id' => $cliente_id,
                'id' => $id
            ]);
            return $row;
        } catch (ValidationException $e) {
            return $e->errors();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     *
     * @OA\Patch(
     *      path="/api/v1/cliente/{cliente_id}/pedido/{id}",
     *      operationId="api.v1.cliente.pedido.update",
     *      tags={"cliente/pedido"},
     *      summary="adicionar items ao  pedido",
     *      description="adicionar items ao pedido",
     *      @OA\Parameter(
     *          name="cliente_id",
     *          description="id do cliente",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="id",
     *          description="id do pedido",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="pastel",
     *          description="array de pasteis",
     *          required=true,
     *          in="query",
     *          type="array",
     *          @OA\Items(type="integer")
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


    public function update(Request $request, $cliente_id , $id)
    {
        try {
            $row = $this->model->find($id);

            foreach($request->pastel as $pastel){
                (new ModelPedidoXPastel())->create(
                    [
                        'pedido_id' => $row->id , 
                        'pastel_id' => $pastel['id']
                    ]
                    );
            }

            return $row;
        } catch (ValidationException $e) {
            return $e->errors();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     *
     * @OA\Post(
     *      path="/api/v1/cliente/{cliente_id}/pedido",
     *      operationId="api.v1.cliente.pedido.store",
     *      tags={"cliente/pedido"},
     *      summary="salvar pedido",
     *      description="salvar pedido",
     *      @OA\Parameter(
     *          name="cliente_id",
     *          description="id do cliente",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="pastel",
     *          description="array de pasteis",
     *          required=true,
     *          in="query",
     *          type="array",
     *          @OA\Items(type="integer")
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

    public function store(Request $request , $cliente_id)
    {
        try {

            $request->request->add([
                'cliente_id' => $cliente_id
            ]);
            Validator::make($request->all(), [
                'cliente_id' => 'required|integer',
            ])->validate();



            $row = $this->model->create([
                'cliente_id' => $cliente_id
            ]);

            if(!$row)
                throw new \Exception('Problema ao criar pedido');
            
            foreach($request->pastel as $pastel){
                (new ModelPedidoXPastel())->create(
                    [
                        'pedido_id' => $row->id , 
                        'pastel_id' => $pastel['id']
                    ]
                    );
            }
            $cliente = Cliente::find($cliente_id);
        
            $email = Mail::send('email/pedido', $row->toArray(), function($message) use ($cliente)
            {
                $message->subject("Pedido criado com sucesso");
                $message->to($cliente->email);
            });
            
            return $row;
        } catch (ValidationException $e) {
            return $e->errors();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     *
     * @OA\Delete(
     *      path="/api/v1/cliente/{cliente_id}/pedido/{id}",
     *      operationId="api.v1.cliente.pedido.destroy",
     *      tags={"cliente/pedido"},
     *      summary="deletar um pedido",
     *      description="deletar um pedido",
     *      @OA\Parameter(
     *          name="cliente_id",
     *          description="id do cliente",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
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

    public function destroy(Request $request , $cliente_id , $id)
    {
        try {
            $row = $this->model->where('id', $id)->where('cliente_id', $cliente_id)->first();
            if ($row) {
                $row->delete();
            }
            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
