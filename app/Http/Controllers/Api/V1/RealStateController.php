<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\RealState;
use App\Http\Requests\RealStateRequest;
use App\Api\ApiMessages;
use Illuminate\Http\Request;
use App\Http\Resources\RealStateResource;

class RealStateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       $realstates=Auth('api')->User()->real_state;
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

            $data['user_id']=Auth('api')->user()->id;
            $realstate = RealState::create($data);

            if(isset($data['categories']) && count($data['categories'])){
                $realstate->categories()->sync($data['categories']);
            }

            if($images){

               $imageUploaded=[];

               foreach($images as $image)
               {
                $path=$image->store('images','public');
                $imageUploaded[]=['photo'=>$path, 'is_thumb'=>false];
               }
               $realstate->photos()->createMany($imageUploaded);
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

        $realstate=auth('api')->user()->real_state()->with('photos')->findOrFail($id);

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
     $images=$request->file('images');

      try {

        $realstate=Auth('api')->user()->real_state()->findOrFail($id)->update($data);

        if(isset($data['categories']) && count($data['categories'])) {
            $realstate->categories()->sync($data['categories']);
        }

        if($images){

            $imageUploaded=[];

            foreach($images as $image)
            {
             $path=$image->store('images','public');
             $imageUploaded[]=['photo'=>$path, 'is_thumb'=>false];
            }
            $realstate->photos()->createMany($imageUploaded);
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
        $realstate=Auth('api')->User()->real_state()->findOrFail($id);

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
