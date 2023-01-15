<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegistarController extends BaseController
{
    public function registar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Enter right cadential', $validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $success['token'] = $user->createToken('RestApi')->plainTextToken;
        $success['name'] = $user->name;
        // return 'User successfully registar';
        return $this->sendResponse('Resistar successfully', $success);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation fail', $validator->errors());
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('RestApi')->plainTextToken;
            $success['name'] = $user->name;
            return $this->sendResponse('Login successfully', $success);
        }
        return 'User unauthanticaed';
    }
    public function logout()
    {
        Auth::user()->tokens()->delete();
        return 'Logout successfully';
    }
}
