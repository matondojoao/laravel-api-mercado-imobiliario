<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RealState;
use App\Http\Resources\RealStateResource;

class RealStateSearchController extends Controller
{

    public function index(Request $request)
    {
       $RealState= RealState::all();

       /*if($request->has('fields')){
       $fields=$request->get('fields');
        $RealState=$RealState->selectRaw($fields);
       }*/

        //$RealState=RealState::paginate(10);
        return new RealStateResource($RealState);
    }
    public function show($id)
    {

    }
}
