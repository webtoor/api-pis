<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\User_role;

class AuthController extends Controller{

    public function register(Request $request){

        $results_user = User::create([
            'username' => $request->json('USERNAME'),
            'password' => Hash::make($request->json('PASSWORD')),
            'firstname' => $request->json('FIRSTNAME'),
            'middlename' => $request->json('MIDDLENAME'),
            'lastname' => $request->json('LASTNAME'),
            'email' => $request->json('EMAIL'),
            'dob' => $request->json('DOB'),
            'sex' => $request->json('SEX'),
        ]);

      $results_role = User_role::create([
            'user_id' => $results_user->id,
            'role_id' => '2'
      ]);
    }

    public function login(Request $request){
        $this->validate($request, [
            'login_types' => 'required',
            'password' => 'required'
        ]);
        global $app; 
        $login_types = $request->json('login_types');
        $password = $request->json('password');

        return $resultUser = User::where('email', $login_types)->orWhere('username', $login_types)->first();
        if($resultUser) {
            if (Hash::check($password, $resultUser->password)) {
                $user_role = $resultUser->role->role_id;
                switch ($user_role) {
                    case "1":
                        $client_secret = 'WdrjbzNyDiE98JZ0vH6K6UpaKoKSbH5hRANvWbix';
                        $client_id = '1';
                        $scope = 'admin';
                        break;
                    case "2":
                        $client_secret = '5UgxNk9xKYX2DO8jFIJS4ceQzBO7kFUYOD2wnk41';
                        $client_id = '2';
                        $scope = 'trainer';
                        break;
                    case "3":
                        $client_secret = '9SFFQANLmBo1vbsJWaqxWQZf1glgDe5gdKyn7nps';
                        $client_id = '3';
                        $scope = 'client';
                        break;
                    default:
                        $error = '';
                }
                if($client_secret && $client_id){
                    $params = [
                        'grant_type'=> 'password',
                        'client_id' => $client_id,
                        'client_secret'=> $client_secret,
                        'username'  => $login_types,
                        'password'  => $password,
                        'scope'     => $scope
                    ];
                    $proxy = Request::create('/oauth/token', 'post', $params);
                    $response = $app->dispatch($proxy);
                    $json = (array) json_decode($response->getContent());
                    $json['user_id'] = $resultUser->id;
                    $json['email'] = $resultUser->email;
                    $json['role_id'] = $resultUser->role->role_id;
                    return $response->setContent(json_encode($json));
                }else{
                         // !Client_Secret
                    return response()->json([
                        "status" => "0",
                        "error" => "invalid_credentials",
                        "message" => "The client_secret credentials were incorrect"
                    ]);
                }
            }else{
                 // Password False
            return response()->json([
                "status" => "0",
                "error" => "invalid_credentials",
                "message" => "The user credentials were incorrect"
               ]);
            }
        }else{
            // User Not Exist
            return response()->json([
                "status" => "0",
                "error" => "invalid_credentials",
                "message" => "The user credentials were incorrect"
               ]);
        }
    }

}