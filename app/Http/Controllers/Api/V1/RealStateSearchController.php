<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RealState;

class RealStateSearchController extends Controller
{

    public function index(Request $request)
    {
       $RealState=new RealState();

       if($request->has('conditions')){
        $expressions=explode(';',$request->get('conditions'));

       foreach($expressions as $e){
          $exp=explode(':',$e);
          $RealState=$RealState->where($exp[0],$exp[1],$exp[2]);
         }
       }
       if($request->has('fields')){
        $fields=$request->get('fields');
        $RealState=$RealState->selectRaw($fields);
       }
        $RealState=RealState::paginate(10);
        return response()->json($RealState, 200);
    }
    public function show($id)
    {
        //
    }
}
