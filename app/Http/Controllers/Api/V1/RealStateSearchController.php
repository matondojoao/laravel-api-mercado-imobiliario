<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RealState;

class RealStateSearchController extends Controller
{

    public function index()
    {
        $RealState=RealState::paginate(10);
        return response()->json($RealState, 200);
    }
    public function show($id)
    {
        //
    }
}
