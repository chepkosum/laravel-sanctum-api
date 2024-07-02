<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Register new user.
     */
    public function register(RegisterRequest $request)
    {
        try {
           $user = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
            'phone'=> $request->phone,
           ]);

           if($user){
           return  ResponseHelper::success(message: 'User has been registered successfully!', data:$user, statusCode:201);
           }
           return  ResponseHelper::error(message: 'Unable to register user!', statusCode:400);

        } catch (Exception $e) {
            \Log::error('Unable to Register User : ' . $e->getMessage() . ' - Line no.' . $e->getLine());
           return  ResponseHelper::error(message: 'Unable to register user!', statusCode:400);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
