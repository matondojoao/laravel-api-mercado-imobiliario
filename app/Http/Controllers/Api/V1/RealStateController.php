<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\RealState;
use App\Http\Requests\RealStateRequest;
use App\Api\ApiMessages;

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
        $data=$request->all();

        $images=$request->file('images');

        try{
            $realstate = RealState::create($data);

            if(isset($data['categories']) && count($data['categories'])){

                $realstate->categories()->sync($data['categories']);
            }

            if($images){
                $imagesUploaded=[];

                foreach($images as $image){
                    $path=$image->store('images','public');

                    $imagesUploaded[]=$path;
                }
            }

             return response()->json([
                'data'=>[
                    'msg'=>'Imóvel cadastrado com sucesso'
                ]
            ], 200);

        }catch(\Throwable $th){

            $message=new ApiMessages($th->getMessage());

            return response()->json(
                $message->getMessage(), 401
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

       try {

        $realstate=RealState::findOrFail($id);

        return response()->json($realstate, 200);

       } catch (\Throwable $th) {

        $message=new ApiMessages($th->getMessage());

        return response()->json(
            $message->getMessage(), 401
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
     $data=$request->all();

      try {

        $realstate=RealState::findOrFail($id)->update($data);

         if(isset($data['categories']) && count($data['categories'])) {
                
    			$realstate->categories()->sync($data['categories']);
		}

        return response()->json([
            
            'msg'=>'Imóvel atualizado com sucesso'
        ], 200);

      } catch (\Throwable $th) {

        $message=new ApiMessages($th->getMessage());

        return response()->json(
            $message->getMessage(), 401
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

       try {
        $realstate=RealState::findOrFail($id);

        $realstate->delete();

        return response()->json([
            'msg'=>'Imóvel excluído com sucesso'
        ], 200);

       } catch (\Throwable $th) {

        $message=new ApiMessages($th->getMessage());
        
        return response()->json(
            $message->getMessage(), 401
        );
       }
    }
}
