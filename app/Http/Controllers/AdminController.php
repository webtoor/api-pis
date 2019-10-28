<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Package;
use App\Models\User_suborganization;
use App\Models\User;
use App\Models\User_role;
use App\Models\User_contact;

class AdminController extends Controller
{
    public function showPackage($admin_id){
        try {
            $userSubOrg = User_suborganization::where('user_id', $admin_id)->first();
            $result = Package::with('suborganization')->where('suborganization_id', $userSubOrg->suborganization_id)->get();
            return response()->json([
                'status' => "1",
                'data' => $result,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => "0",
                'error' => $e->getMessage()
            ]);
        }
      
    }

    public function createPackage(Request $request){

        $data = $this->validate($request, [
            'packagename' => 'required|string|regex:/^[\w- ]*$/',
            'suborganization_id' => 'required',
            'totalsession' => 'required|numeric',
            'duration' => 'required|numeric',
            'defaultprice' => 'required|numeric',
            'dtstart' => 'required|date|date_format:Y-m-d',
            'dtend' => 'required|date|date_format:Y-m-d',
        ]);

        try {
            $result = Package::create([
                'packagename' => $data['packagename'],
                'suborganization_id' => $data['suborganization_id'],
                'totalsession' => $data['totalsession'],
                'duration' => $data['duration'],
                'defaultprice' => $data['defaultprice'],
                'dtstart' => $data['dtstart'],
                'dtend' => $data['dtend'],
                'active' => 1
            ]);
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
    public function updatePackage(Request $request, $package_id){
        $data = $this->validate($request, [
             'packagename' => 'string|regex:/^[\w- ]*$/',
             'totalsession' => 'numeric',
             'duration' => 'numeric',
             'defaultprice' => 'numeric',
             'dtstart' => 'date|date_format:Y-m-d',
             'dtend' => 'date|date_format:Y-m-d',
             'active' => 'required'
         ]);
 
         try {
             $check_package = Package::findOrFail($package_id);
             $check_package->update($data);
             return response()->json([
                 'status' => "1",
                 'message' => "success",
             ]);
         } catch(\Exception $e) {
             return response()->json([
                 'status' => "0",
                 'error' => $e->getMessage()
             ]);
         }
     }
 
     public function deletePackage($package_id){
         try {
             Package::where('package_id', $package_id)->delete();
             // ALTER TABLE tablename AUTO INCREMENT = 1
             DB::statement("ALTER TABLE packages AUTO_INCREMENT = 1");
             return response()->json([
                 'status' => "1",
                 'message' => "success",
             ]);
         } catch(\Exception $e) {
             return response()->json([
                 'status' => "0",
                 'error' => $e->getMessage()
             ]);
         }
     
     }


     public function showAllTrainer($admin_id){
        try {
            $check = User_suborganization::where('user_id', $admin_id)->first();
            $result = User_suborganization::with(['trainer','role' => function ($query) {
                $query->where('role_id', '2');
            }])->where('suborganization_id', $check->suborganization_id)->get();
            $results = $result->filter(function ($value) {
              return $value['role'] != null;
            })->values();

            return response()->json([
                'status' => "1",
                'data' => $results,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => "0",
                'error' => $e->getMessage()
            ]);
        }
     }

     public function showTrainer($trainer_id){
        try {
          $results = User_suborganization::with('suborganization', 'user')->where('user_id', $trainer_id)->first();
            return response()->json([
                'status' => "1",
                'data' => $results,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => "0",
                'error' => $e->getMessage()
            ]);
        }
     }

     public function createTrainer(Request $request){
       $data = $this->validate($request, [
            'username' => 'required|string|unique:users|regex:/^[\w- ]*$/',
            'firstname' => 'required|string|regex:/^[\w- ]*$/',
            'middlename' => 'string|regex:/^[\w- ]*$/',
            'lastname' => 'required|string|regex:/^[\w- ]*$/',
            'phonenumber' => 'required|string|min:11',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5|confirmed',
            'dob' => 'required|date|date_format:Y-m-d',
            'sex' => 'required',
            'suborganization_id' => 'required',
        ]);

        try {
            $results = User::create([
                'username' => $data['username'],
                'firstname' => $data['firstname'],
                'middlename'=> $data['middlename'],
                'lastname'=> $data['lastname'],
                'password'=> Hash::make($data['password']),
                'email'=> $data['email'],
                'dob'=> $data['dob'],
                'sex' => $data['sex']
            ]);
    
           $results_role = User_role::create([
                'user_id' => $results->id,
                'role_id' => '2'
           ]);
           $results_suborg = User_suborganization::create([
               "user_id" => $results->id,
               "suborganization_id" => $data['suborganization_id'],
               "dtjoined" => $results->created_at,
               "active" => "1"
           ]);
           
           $dtstart = date("Y-m-d", strtotime($results->created_at));
           $results_contactPhone = User_contact::create([
                "user_id" => $results->id,
                "contacttype_id" => '2',
                "contactvalue" => $data['phonenumber'],
                "dtstart" => $dtstart
            ]);

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

     public function updateTrainer(Request $request, $trainer_id){
        $data = $this->validate($request, [
            'username' => 'string|regex:/^[\w- ]*$/|unique:users,username,'.$trainer_id,
            'firstname' => 'string|regex:/^[\w- ]*$/',
            'middlename' => 'string|regex:/^[\w- ]*$/',
            'lastname' => 'string|regex:/^[\w- ]*$/',
            'phonenumber' => 'string|min:11',
            'email' => 'required|email|unique:users,email,'.$trainer_id, 
            'dob' => 'date|date_format:Y-m-d',
            'sex' => 'string',
            'suborganization_id' => 'required',
            'active' => "string"
        ]);

        try {
            $check_trainer = User::findOrFail($trainer_id);
            $check_trainer->update($data);

            $check_suborg = User_suborganization::where('user_id', $trainer_id);
            $check_suborg->update([
                'active' => $data['active']
            ]);
            
            $today_date = date("Y-m-d", strtotime('now'));
            $check_contact_phone = User_contact::where(['user_id' => $trainer_id, 'contacttype_id' => '2']);
            $check_contact_phone->update([
                "user_id" => $trainer_id,
                "contactvalue" => $data['phonenumber'],
                "dtstart" => $today_date
            ]);
            return response()->json([
                'status' => "1",
                'message' => "success",
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status' => "0",
                'error' => $e->getMessage()
            ]);
        }
     }

     public function deleteTrainer($trainer_id){
        try {
            User::where('id', $trainer_id)->delete();
            // ALTER TABLE tablename AUTO INCREMENT = 1
            DB::statement("ALTER TABLE users AUTO_INCREMENT = 1");
            return response()->json([
                'status' => "1",
                'message' => "success",
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status' => "0",
                'error' => $e->getMessage()
            ]);
        }
    }


    public function showTotalTrainer($admin_id){
        try {
              $check = User_suborganization::where('user_id', $admin_id)->first();
              $result = User_suborganization::with(['role' => function ($query) {
                  $query->where('role_id', '2');
              }])->where('suborganization_id', $check->suborganization_id)->get();
              $results = $result->filter(function ($value) {
                  return $value['role'] != null;
              })->values();
              return response()->json([
                  'status' => "1",
                  'data' => count($results)
              ]);
        } catch(\Exception $e) {
          return response()->json([
              'status' => "0",
              'error' => $e->getMessage()
          ]);
        }
  }
}
