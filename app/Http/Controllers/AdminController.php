<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;

class AdminController extends Controller
{

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
                'data' => $result,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => "0",
                'error' => $e->getMessage()
            ]);
        }
        
    }
}
