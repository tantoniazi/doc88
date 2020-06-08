<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Model\Pastel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Image;

class PastelController extends Controller
{
  
    public function __construct(Pastel $model)
    {
        $this->model  = $model;
    }

     /**
     *
     * @OA\Get(
     *      path="/api/v1/pastel",
     *      operationId="api.v1.pastel.index",
     *      tags={"pastel"},
     *      summary="recuperar lista de pasteis",
     *      description="recuperar lista de pasteis",
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
     *      path="/api/v1/pastel/{id}",
     *      operationId="api.v1.pastel.show",
     *      tags={"pastel"},
     *      summary="recuperar dados de um pastel",
     *      description="recuperar dados de um pastel",
     *      @OA\Parameter(
     *          name="id",
     *          description="id do pastel",
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

    public function show(Request $request,$id)
    {
        try {
            $row = $this->model->find($id);
            return $row;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     *
     * @OA\Patch(
     *      path="/api/v1/pastel/{id}",
     *      operationId="api.v1.pastel.update",
     *      tags={"pastel"},
     *      summary="atualizar dados do pastel",
     *      description="atualizar dados do pastel",
     *      @OA\Parameter(
     *          name="id",
     *          description="id do pastel",
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

    public function update(Request $request, $id)
    {
        try {
            Validator::make($request->all(), [
                'nome' => 'nullable|string',
                'preco' => 'nullable|string',
                'foto' =>  'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ])->validate();
            $row = $this->model->find($id)->update($request->all());
            return $row;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     *
     * @OA\Post(
     *      path="/api/v1/pastel/{id}",
     *      operationId="api.v1.pastel.show",
     *      tags={"pastel"},
     *      summary="salvar pastel",
     *      description="salvar pastel",
     *      @OA\Parameter(
     *          name="nome",
     *          description="nome do pastel",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="preco",
     *          description="preco do pastel",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="numeric"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="foto",
     *          description="foto do pastel",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="image"
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
                'preco' => 'nullable|string',
                'foto' =>  'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ])->validate();
   

            $path   = $request->file('foto');
            $img = Image::make($path->getRealPath());
            
            dd($img);
            $img->move('/public/pastel');

            $params = [
                'nome' => $request->nome , 
                'preco' => $request->preco , 
                'foto' =>  'public/pastel'
            ];

            $row = $this->model->create($params);
            return $row;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}