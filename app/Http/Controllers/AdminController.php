<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\User_suborganization;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function showPackage($user_id){
        try {
            $userSubOrg = User_suborganization::where('user_id', $user_id)->first();
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

}
