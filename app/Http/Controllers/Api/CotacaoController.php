<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\StoreUpdateCotacao;
use App\Http\Resources\CalculoResource;
use App\Http\Resources\CotacaoResource;
use App\Models\cotacao_frete;
use App\Models\transportadora;
use Exception;
use Illuminate\Support\Facades\DB;

class CotacaoController extends Controller
{
    protected $repository;

    public function __construct(cotacao_frete $model, transportadora $transportadora)
    {
        $this->repository = $model;
        $this->repositoryTransportadora = $transportadora;
    }

    public function index(Request $request)
    {


        $cotacoes= $this->repository->get();
        return $cotacoes;

    }

    public function transportadora(Request $request)
    {

        $transportadoras= $this->repositoryTransportadora->get();
        return $transportadoras;

    }


    public function store(StoreUpdateCotacao $request)
    {

        $uf = $request->uf;
        $transportadora_id = $request->transportadora_id;
        $validaUF = cotacao_frete::where('uf',$uf)->where('transportadora_id',$transportadora_id)->first();

        if(isset($validaUF)){

            $returnData = array(
                'status' => 'error',
                'message' => 'erro: UF e Transportadora precisa ser Unico'
            );
            return response()->json($returnData, 500);


        }else{

            $cotacoes = $this->repository->create($request->validated());
            return response()->json(['messagem' => 'Sucesso'], 200);
        }



        /**
         *  Caso queira pode desabilidar a linha a cima e habilidar
         *  O outro returno para verificar os dados
         */

        //return new CotacaoResource($cotacoes);


    }

    public function show($id)
    {
        $cotacoes = $this->repository->where('id', $id)->firstOrFail();

        return new CotacaoResource($cotacoes);
    }


    public function update(StoreUpdateCotacao $request, $id)
    {

        $uf = $request->uf;
        $transportadora_id = $request->transportadora_id;
        $validaUF = cotacao_frete::where('uf',$uf)->where('transportadora_id',$transportadora_id)->first();

        if(isset($validaUF)){

            return response()->json(['messagem' => 'erro: UF e Transportadora precisa ser Unico']);

        }else{

            $cotacoes = $this->repository->where('id', $id)->firstOrFail();
            $cotacoes = $this->repository->update($request->validated());
            return response()->json(['messagem' => 'Sucesso'], 200);
        }



    }


    public function destroy($id)
    {
        $cotacoes = $this->repository->where('id', $id)->firstOrFail();

        $cotacoes->delete();

        return response()->json([], 204);
    }

    public function calculo(Request $request)
    {
        //RECEBE REQUEST
        $uf = $request->uf;
        $valor_pedido = $request->valor_pedido;

        //LOCALIZA
        //$cotacoes = cotacao_frete::where('uf', $uf)->get();

        $cotacoes = DB::select("SELECT uf, transportadora_id, '$valor_pedido' as  valor_pedido,
                        ($valor_pedido/100 * porcentual_cotacao) + valor_extra as valor_cotacao
                        FROM cotacaodb.cotacao_fretes
                        WHERE uf = '$uf'
                        ORDER BY valor_cotacao
                        LIMIT 3
                        ");


        //APRESENTA

        if($cotacoes){

            return $cotacoes;

        }else{

            return response()->json(['message' => 'Cotação não cadastrada o UF'], 500);

        }

           //return new CalculoResource($cotacoes);

    }

    public function calcular(Request $request)
    {

        //RECEBE REQUEST
        $uf = $request->uf;
        $valor_pedido = $request->valor_pedido;



        //LOCALIZA
        //$cotacoes = cotacao_frete::where('uf', $uf)->get();
        if(isset($request)){

            $cotacoes = DB::select("SELECT uf, transportadora_id, '$valor_pedido' as  valor_pedido,
                        ($valor_pedido/100 * porcentual_cotacao) + valor_extra as valor_cotacao
                        FROM cotacaodb.cotacao_fretes
                        WHERE uf = '$uf'
                        ORDER BY valor_cotacao
                        LIMIT 3
                        ");

                if($cotacoes){

                    return $cotacoes;

                }else{

                    return response()->json(['message' => 'Erro no Relatorio'], 500);

                }

        }else{

            return response()->json(['message' => 'UF ou valor Pedido esta em branco'], 500);

        }



        //APRESENTA





        //return new CalculoResource($cotacoes);


    }
}
