<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RealStatePhoto;
use Illuminate\Support\Facades\Storage;

use App\Api\ApiMessages;

class RealStatePhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function setTumb($photoId ,$realstateId)
    {
       try {
          $photo=RealStatePhoto::where('real_state_id',$realstateId)
                 ->where('is_thumb', true);
          
          if($photo->count())
              $photo->update(['is_thumb'=>false])->first();

          $photo=RealStatePhoto::find($photoId)->update(['is_thumb'=>true]);

          return response()->json([
            'msg'=>'Tumb atualizada com sucesso'
          ], 200);
          
       } catch (\Throwable $th) {
          $message=new ApiMessages($th->getMessage());
          return response()->json([$message->getMessage()], 401);
       }
    }
    public function remove($photoId)
    {
        try {
            $photo=RealStatePhoto::find($photoId);
                
            if($photo->is_thumb){
               $message=new ApiMessages("Não é possivel remover a foto de thumb, seleciona outra thumb e remova a imagem desejada");
               return response()->json([$message->getMessage()], 401);
            }
            if($photo){
               Storage::disk('public')->delete($photo->photo);
               $photo->delete();
            }
  
            return response()->json([
              'msg'=>'Foto excluída com sucesso'
            ], 200);
            
         } catch (\Throwable $th) {
            $message=new ApiMessages($th->getMessage());
            return response()->json([$message->getMessage()], 401);
         }
    }
    
}
