<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Api\ApiMessages;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=User::paginate(10);
        return response()->json($user, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $use= new User();
        $data=$request->all();

        $data['password']=Hash::make($data['password']);
        
        if(!$request->has('password') || !$request->get('password')){

            $message=new ApiMessages('A password is required for the user');

            return response()->json($message->getMessage(), 401);
        }
        
       Validator::make($data, [
        'phone'=>'required',
        'mobile_phone'=>'required'
       ])->validate();

       try {

        $user=User::create($data);

        $user->profile()->create(
            [
                'phone'=>$data['phone'],
                'mobile_phone'=>$data['mobile_phone']
            ]
        );

        return response()->json([
            'msg'=>'Usuário criado com sucesso'
        ], 200);

       } catch (\Throwable $th) {

           $message=new ApiMessages($th->getMessage());

           return response()->json([$th->getMessage()], 401);
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
            
            $user=User::with('profile')->findOrFail($id);

            return response()->json($user, 200);

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
    public function update(UserRequest $request, $id)
    {
        $data=$request->all();
        
        if($request->has('password') && $request->get('password')){

            $data['password']=Hash::make($data['password']);
        }
        else{
            unset($data['password']);
        }
        Validator::make($data, [
            'profile.phone' => 'required',
		    'profile.mobile_phone' => 'required'
           ])->validate();

        try {
        
            $profile = $data['profile'];
	    	$profile['social_networks'] = serialize($profile['social_networks']);

        $user=User::findOrFail($id)->update($data);
        
        $user->profile()->update($profile);

        return response()->json([

            'msg'=>'Usuário atualizado com sucesso'
            
        ], 200);

       } catch (\Throwable $th) {

          $message=new ApiMessages($th->getMessage());

          return response()->json([$th->getMessage()]);
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

        $user=User::findOrFail($id);
        $user->delete();

        return response()->json([
            'msg'=>'Usuário excluído com sucesso'
        ], 200);

       } catch (\Throwable $th) {

         $message=new ApiMessages($th->getMessage());

         return response()->json([$th->getMessage()]);
       }
    }
}
