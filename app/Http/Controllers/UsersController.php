<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    function getToken(Request $request){
        if($request->isJson()){
            try {
                $data = $request->json()->all();
                $user = User::where('username', $data['username'])->first();

                if ($user && Hash::check($data['password'], $user->password)){
                    return response()->json(['api_key' => $user.api_key], 200);
                }
                else {
                    return response()->json(['error' => 'no hay contenido'], 406);
                }
            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'no hay contenido'], 406);
            }
        }
        return response()->json(['error' => 'no autorizado'], 401);
    }

    function index(Request $request){
        if($request->isJson()){
            $users = User::all();
            //$users = User::all('name','email');
            return response()->json('{ "results" :'. $users . '}', 200);
        }
        return response()->json(['error' => 'no autorizado'], 401);
    }

    function showOneUser(Request $request, $id){
        if($request->isJson()){
            $users = User::find($id);
            return response()->json($users, 200);
        }
        return response()->json(['error' => 'no autorizado'], 401);
    }

    function createUser(Request $request){
        if($request->isJson()){

            $validator = $this->validate($request, [
                'name' => 'required',
                'username' => 'required',
                'email' => 'required'
            ]);

            $data = $request->json()->all();
            $user = User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'remember_token' => $data['remember_token'],
                'api_token' => str_random(60)
            ]);
            return response()->json($user, 201);
        }
        return response()->json(['error' => 'no autorizado'], 401);
    }

    function updateUser(Request $request, $id){
        if($request->isJson()){
            $user = User::findorfail($id);
            $user->update($request->json()->all());
            return response()->json($user, 200);
        }
        return response()->json(['error' => 'no autorizado'], 401);
    }

    function deleteUser(Request $request, $id){
        if($request->isJson()){
            $user = User::findorfail($id);
            $user->delete();
            return response()->json($user, 200);
        }
        return response()->json(['error' => 'no autorizado'], 401);
    }
}
