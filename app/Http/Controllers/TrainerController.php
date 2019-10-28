<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\User_contact;

class TrainerController extends Controller
{   

    public function showProfile(){
        $accessToken = Auth::user()->token();
        try {
            $trainer = User::with('contact_mobile')->where('id', $accessToken->user_id)->first();
            return response()->json([
                'status' => "1",
                'data' => $trainer
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => "0",
                'error' => $e->getMessage()
            ]);
        }

    }
    public function updateProfile(Request $request, $trainer_id){
        $data = $this->validate($request, [
            'firstname' => 'required|string|regex:/^[\w- ]*$/',
            'middlename' => 'string|regex:/^[\w- ]*$/',
            'lastname' => 'required|string|regex:/^[\w- ]*$/',
            'phonenumber' => 'required|string|min:11',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        try {
            $check_user = User::findOrFail($trainer_id);
            $check_user->update($data);
            return response()->json([
                'status' => "1",
                'message' => "success",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => "0",
                'error' => $e->getMessage()
            ]);
        }


    }
}
