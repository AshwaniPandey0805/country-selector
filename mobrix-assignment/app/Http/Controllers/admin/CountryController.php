<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Constraint\Count;

class CountryController extends Controller
{

    public function create(){
        $countries = Country::orderby('country_name', 'ASC')->get();
        $data['countries'] = $countries;
        return view('admin.country.create', $data);
    }

    public function store(Request $request){
        // dd($request->all());
        $validate = Validator::make($request->all(),[
            'name' => 'required|string',
            'status' => 'required' 
        ]);

        if($validate->passes()){

            $country = new Country();
            $country->country_name = $request->name;
            $country->status = $request->status;
            $country->save();

            return response()->json([
                'status' => true,
                'message' => 'Country created'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validate->errors()
            ]);
        }
    }

    public function edit($id){
        $country = Country::find($id);
        $data['country'] = $country;
        return view('admin.country.edit',$data);
    }

    public function update($id, Request $request){
        $country = Country::find($id);
        $validate = Validator::make($request->all(),[
            'name' => 'required|string',
            'status' => 'required' 
        ]);

        if($validate->passes()){
            $country->country_name = $request->name;
            $country->status = $request->status;
            $country->save();

            return response()->json([
                'status' => true,
                'message' => 'Country updated'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'error' => $validate->errors()
            ]);
        }

    }

    public function delete($id){
        $country = Country::find($id);
        $country->delete();

        return redirect()->route('country.create');
    }


}

