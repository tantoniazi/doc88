<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Model\Cliente;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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

            $row = $this->model->find($id);
            return $row;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


     /**
     *
     * @OA\Patch(
     *      path="/api/v1/cliente/{id}",
     *      operationId="api.v1.cliente.update",
     *      tags={"cliente"},
     *      summary="atualizar dados do cliente",
     *      description="atualizar dados do cliente",
     *      @OA\Parameter(
     *          name="id",
     *          description="id do cliente",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="nome",
     *          description="nome",
     *          required=false,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="email",
     *          description="email",
     *          required=false,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="telefone",
     *          description="telefone",
     *          required=false,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="data_nascimento",
     *          description="data_nascimento",
     *          required=false,
     *          in="path",
     *          @OA\Schema(
     *              type="date"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="endereco",
     *          description="endereco",
     *          required=false,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="complemento",
     *          description="complemento",
     *          required=false,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="bairro",
     *          description="bairro",
     *          required=false,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="cep",
     *          description="cep",
     *          required=false,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
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

    public function update(Request $request, $id)
    {
        try {
            Validator::make($request->all(), [
                'nome' => 'string',
                'email' => 'string|unique:cliente|max:255',
                'telefone' => 'string',
                'data_nascimento' => 'date',
                'endereco' => 'string',
                'complemento' => 'string',
                'bairro' => 'string',
                'cep' => 'string',
            ])->validate();
                
            $row = $this->model->find($id)->update($request->all());
            
            if(!$row)
                throw new \Exception("Erro ao atualizar");

            return $this->model->find($id);
            
        } catch (ValidationException $e){
            return $e->errors();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     *
     * @OA\Post(
     *      path="/api/v1/cliente/{id}",
     *      operationId="api.v1.cliente.show",
     *      tags={"cliente"},
     *      summary="salvar cliente",
     *      description="salvar cliente",
     *      @OA\Parameter(
     *          name="nome",
     *          description="nome",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="email",
     *          description="email",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="email"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="telefone",
     *          description="telefone",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="image"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="data_nascimento",
     *          description="data_nascimento",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="date"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="endereco",
     *          description="endereco",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="complemento",
     *          description="complemento",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="bairro",
     *          description="bairro",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="cep",
     *          description="cep",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
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

    public function store(Request $request)
    {
        try {
             Validator::make($request->all(), [
                'nome' => 'required|string',
                'email' => 'required|string|unique:cliente|max:255',
                'telefone' => 'required|string',
                'data_nascimento' => 'required|date',
                'endereco' => 'required|string',
                'complemento' => 'required|string',
                'bairro' => 'required|string',
                'cep' => 'required|string',
            ])->validate();
   
            $params = [
                'nome' => $request->nome,
                'email' => $request->email,
                'telefone' => $request->telefone,
                'data_nascimento' => $request->data_nascimento,
                'endereco' => $request->endereco,
                'complemento' => $request->complemento,
                'bairro' => $request->bairro,
                'cep' => $request->cep,
            ];

            $row = $this->model->create($params);
            return $row;
        } catch (ValidationException $e){
            return $e->errors();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     *
     * @OA\Delete(
     *      path="/api/v1/cliente/{id}",
     *      operationId="api.v1.cliente.destroy",
     *      tags={"cliente"},
     *      summary="deletar um cliente",
     *      description="deletar um cliente",
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

    public function destroy($id)
	{
		try{
            $row = $this->model->find($id);
            if($row)
                $row->delete();
		    return true;  
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

}
