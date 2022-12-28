<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RealState;
use App\Http\Resources\RealStateResource;

class RealStateSearchController extends Controller
{

    public function index()
    {
       $RealState= RealState::all();
       return response()->json($RealState);
    }
    public function show($id)
    {

    }
}
