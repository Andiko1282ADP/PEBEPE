<?php

namespace App\Http\Controllers\API;


use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Fortify\Rules\Password;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException as IlluminateValidationException;
use Laravel\Fortify\Contracts\LoginViewResponse as LoginViewResponseContract;

class UserController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
    
            $user = User::where('email', $request->email)->first();
            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            };

            $tokenresult = $user->createToken('authToken')->plainTextToken;
            $res = [
                'token' => $tokenresult,
                'type_token' => 'Bearer',
                'user' => $user
            ];
            return response()->json($res, 200);
        } catch (Exception $error) {
            $res = [
                "message" => "Something went wrong",
            ];
            return response()->json($res, 500);
        }
    }

    

    public function toResponse($request)
    {
        // Return the login view, you can customize this as needed
        return view('auth.login');
    }

    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'min:3', 'max:255'],
                'username' => ['required', 'string', 'min:3', 'max:255'],
                'email' => ['required', 'email', 'string', 'min:3', 'max:255', 'unique:users'],
                'password' => ['required', 'string'],
                'phone' => ['nullable', 'string', 'min:3', 'max:255'],
                'gender' => ['required', 'string', 'min:3', 'max:255'],
                'isAdmin' => ['string']
            ]);

            $user = User::create([
                'name' => $validatedData['name'],
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'phone' => $validatedData['phone'],
                'gender' => $validatedData['gender'],
                'isAdmin'=> $validatedData['isAdmin']
            ]);

            // If you want to log the user in immediately after registration, you can create a token here
            $tokenresult = $user->createToken('authToken')->plainTextToken;

            $res = [
                'token' => $tokenresult,
                'type_token' => 'Bearer',
                'user' => $user
            ];

            return response()->json($res, 201); // 201 status code for resource created
        } catch (IlluminateValidationException $e) {
            // Validation failed, retrieve the errors
            $errors = $e->validator->errors()->messages();
            // Now you can handle the errors as needed, such as returning them as a response
            return response()->json(['errors' => $errors], 422);
        } catch (\Exception $e) {
            dd($e);
            // Handle other exceptions
            return response()->json(['message' => 'Something went wrong'], 500);
        }
    }


    public function fetch(Request $request)
    {
        return response()->json([
            ['status' => 200, 'message' => 'Success get data', $request->user()],
            200,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $data = $request->all();

        $user = Auth::user();
        $user->update($data);

        return response()->json(
            ['code' => 200, 'message' => 'Data Updated', 'data' => $user],
            200,
        );
    }
    

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccesstoken()->delete();

        return response()->json(
            [
                'message' => 'Token Revoked',
                'access_token' => $token,
                'code' => 200
            ],
            200,
        );
    }
}
