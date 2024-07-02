<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
     * @param App\Requests\RegisterRequest $request
     * @return JSONResponse
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
           return  ResponseHelper::error(message: 'Unable to Register user!' . $e->getMessage(), statusCode:500);

        }
    }

    /**
     * login user.
     * @param App\Requests\LoginRequest $request
     * @return JSONResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            //if credentials are incorrect
            if (!Auth::attempt(['email'=> $request->email,'password' => $request->password,])){
           return  ResponseHelper::error(message: 'Unable to Login user! Invalid credentials ' , statusCode:400);
            }

           $user =  Auth::user();

           //Create API Token
           $token = $user->createToken('My API Token')->plainTextToken;

           $authUser = [
            'user' => $user,
            'token' => $token
           ];
           return  ResponseHelper::success(message: 'You are logged in successfully!', data:$authUser, statusCode:200);

        } catch (Exception $e) {
            \Log::error('Unable to Login User : ' . $e->getMessage() . ' - Line no.' . $e->getLine());
           return  ResponseHelper::error(message: 'Unable to Login user!' . $e->getMessage(), statusCode:500);

        }
    }

    /**
     * Get user profile data.
     * @param NA
     * @return JSONResponse
     */
    public function userProfile()
    {
        try {
           $user =  Auth::user();

           if($user){
           return  ResponseHelper::success(message: 'User Profile Fetched!', data:$user, statusCode:200);
           }
           return  ResponseHelper::error(message: 'Unable to Fetch user Profile! Invalid Token' , statusCode:400);

        } catch (Exception $e) {
            \Log::error('Unable to Fetch User Profile : ' . $e->getMessage() . ' - Line no.' . $e->getLine());
           return  ResponseHelper::error(message: 'Unable to Fetch user Profile!' . $e->getMessage(), statusCode:500);

        }
    }

   /**
     * Logout user.
     * @param NA
     * @return JSONResponse
     */
    public function logout()
    {
        try {
           $user =  Auth::user();

           if($user){
            $user->currentAccessToken()->delete();
           return  ResponseHelper::success(message: 'User Logged Out!', statusCode:200);
           }
           return  ResponseHelper::error(message: 'Unable to logout! Invalid Token' , statusCode:400);

        } catch (Exception $e) {
            \Log::error('Unable to Logout : ' . $e->getMessage() . ' - Line no.' . $e->getLine());
           return  ResponseHelper::error(message: 'Unable to logout!' . $e->getMessage(), statusCode:500);

        }
    }

}
