<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\RealState;
use App\Http\Requests\RealStateRequest;

class RealStateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $realstates=RealState::paginate(10);
        return response()->json($realstates);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RealStateRequest $request)
    {
        $data = RealState::create($request->all());

        try{
             return response()->json([
                'data'=>[
                    'msg'=>'Imóvel cadastrado com sucesso'
                ]
            ], 200);
        }catch(\Throwable $th){

            return response()->json(
                ['erros'=> $th->getMessage()], 401
             );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $realstate=RealState::findOrFail($id);

       try {

        return response()->json($realstate, 200);

       } catch (\Throwable $th) {

        return response()->json(
                ['erros'=> $th->getMessage()], 401
        );
       }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RealStateRequest $request, $id)
    { 

      try {

        $realstate=RealState::findOrFail($id)->update($request->all());

        return response()->json([
            'msg'=>'Imóvel atualizado com sucesso'
        ], 200);

      } catch (\Throwable $th) {

       return response()->json(
           ['erros'=> $th->getMessage()], 401
        );
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
       $realstate=RealState::findOrFail($id);

       try {

        $realstate->delete();

        return response()->json([
            'msg'=>'Imóvel excluído com sucesso'
        ], 200);

       } catch (\Throwable $th) {

        return response()->json(
                ['erros'=> $th->getMessage()], 401
        );
       }
    }
}
