<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Api\ApiMessages;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $category=Category::paginate(10);
       return response()->json($category);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        try {

            $category=Category::create($request->all());

            return response()->json([
                'msg'=>'Categoria criada com sucesso'
            ], 200);

        } catch (\Throwable $th) {

            $message=new ApiMessages($th->getMessage());

            return response()->json([$message->getMessage()], 401);
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

            $category=Category::findOrFail($id);

            return response()->json($category,200);

        } catch (\Throwable $th) {

            $message=new ApiMessages($th->getMessage());

            return response()->json([$message->getMessage()], 401);
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        try {

            $category=Category::findOrFail($id)->update($request->all());

            return response()->json([
                'msg'=>'Categoria atualizado com sucesso'
            ], 200);

        } catch (\Throwable $th) {

            $message=new ApiMessages($th->getMessage());

            return response()->json([$message->getMessage()], 401);
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

            $category=Category::findOrFail($id);

            $category->delete();

            return response()->json([
                'msg'=>'Categoria excluída com sucesso'
            ], 200);

        } catch (\Throwable $th) {

            $message=new ApiMessages($th->getMessage());

            return response()->json([$message->getMessage()], 401);
        }
    }

    public function realstates($id){
        try {
            $category=Category::findOrFail($id);

            return response()->json([
                'data'=>$category->realstates
            ], 200);

        } catch (\Throwable $th) {

           $message= new ApiMessages($th->getMessage());

           return response()->json([$th->getMessage()], 401);
        }
    }
}
