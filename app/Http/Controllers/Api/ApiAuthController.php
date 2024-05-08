<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    public function createUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'name' => 'required',
                'phone' => 'required|numeric',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'role' => 'required|string|in:Spa owner,Staff,Client'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone,
                'role' => $request->role,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone_number,
                    'role' => $user->role
                ],
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
            [
                'phone_number' => 'numeric',
                'email' => 'email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }


//  "phone_number":"0493848833"

if (!Auth::attempt($request->only(['phone_number', 'password'])) && !Auth::attempt($request->only(['email', 'password']))) {
    return response()->json([
        'status' => false,
        'message' => 'Email & Password or Phone & Password do not match with our records.',
    ], 401);
}
            if(!$request->email){
                $user = User::where('phone_number', $request->phone_number)->first();
            }else{
                $user = User::where('email', $request->email)->first();

        }
            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone_number,
                    'role' => $user->role
                ],
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


function editProfil(Request $request){
    try{
        $validateUser = Validator::make($request->all(),
        [
            'phone_number' => 'numeric',
            'name' => 'string'
        ]);

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }
if($request->user_id){
    $user = $request->user_id;
    $user = User::where('id', $user)->first();
}

if($request->phone){
     $phone = $request->phone;
     $user->phone_number = $phone;
    }
if($request->name){
     $name = $request->name;
     $user->name = $name;
    }
if($request->password){
     $user->password =Hash::make($request->password);
    }


    $user->save();
    if ($request->image != null) {
        if ($request->hasFile('image')) {
            $existingMedia = $user->getFirstMedia();

            if ($existingMedia) {
                $existingMedia->delete();
            }
            $user->addMediaFromRequest('image')
                ->usingName($user->name)
                ->toMediaCollection();
        }
    }
} catch (\Throwable $th) {
    return response($th);
}
return response()->json(["msg","Profil has been updated"],200);

}


function loginWithGoogle(Request $request){

    $validateUser = Validator::make($request->all(),
    [
        'name' => 'required',
        'email' => 'required|email',
        'role' => 'required|string|in:Spa owner,Staff,Client'
    ]);

    if($validateUser->fails()){
        return response()->json([
            'status' => false,
            'message' => 'validation error',
            'errors' => $validateUser->errors()
        ], 401);
    }


    try{
   $email =   $request->email ;
   $user = User::where('email', $email)->exists();

   if($user){
       $user = User::where('email', $email)->first();

       return response()->json([
        'status' => true,
        'message' => 'User Logged In Successfully',
        'data' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone_number,
            'role' => $user->role
        ],
        'token' => $user->createToken("API TOKEN")->plainTextToken
    ], 200);

   }else{
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
        'password' => Hash::make($request->name."Password". $request->email),
    ]);

    return response()->json([
        'status' => true,
        'message' => 'User Created Successfully',
        'data' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone_number,
            'role' => $user->role
        ],
        'token' => $user->createToken("API TOKEN")->plainTextToken
    ], 200);
   }

} catch (\Throwable $th) {
    return response()->json([
        'status' => false,
        'message' => $th->getMessage()
    ], 500);
}

}







}
