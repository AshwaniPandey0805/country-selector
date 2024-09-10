<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    public function create(){
        $cities = City::select('cities.*','states.state_name','countries.country_name')
                        ->orderBy('city_name', 'ASC')
                        ->leftJoin('countries','countries.id', '=', 'cities.country_id')
                        ->leftJoin('states', 'states.id', '=', 'cities.state_id')
                        ->get();
        $countries = Country::orderBy('country_name', 'ASC')->get();
        $data['cities'] = $cities;
        $data['countries'] = $countries;
        return view('admin.city.create', $data);
    }

    public function store(Request $request){
        // dd($request->all());
        $validate = Validator::make($request->all(),[
            'name' => 'required|string',
            'country' => 'required',
            'state' => 'required',
            'status' => 'required' 
        ]);

        if($validate->passes()){

            $state = new City();
            $state->city_name = $request->name;
            $state->state_id = $request->state;
            $state->country_id = $request->country;
            $state->status = $request->status;
            $state->save();

            return response()->json([
                'status' => true,
                'message' => 'city created'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validate->errors()
            ]);
        }
    }

    public function edit($id){
        $city = City::find($id);
        $countries = Country::orderby('country_name', 'ASC')->get();
        $state = State::where('id', $city->State_id)->first();
        $data['state'] = $state;
        $data['countries'] = $countries;
        $data['city'] = $city;
        return view('admin.city.edit',$data);
    }

    public function update($id, Request $request){
        $city = City::find($id);
        $validate = Validator::make($request->all(),[
            'name' => 'required|string',
            'country' => 'required',
            'state' => 'required',
            'status' => 'required' 
        ]);

        if($validate->passes()){
            $city->city_name = $request->name;
            $city->state_id = $request->state;
            $city->country_id = $request->country;
            $city->status = $request->status;
            $city->save();

            return response()->json([
                'status' => true,
                'message' => 'State updated'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'error' => $validate->errors()
            ]);
        }

    }

    public function delete($id){
        $city = City::find($id);
        $city->delete();

        return redirect()->route('city.create');
    }

    public function getStates(Request $request){
        $states = State::select('states.state_name', 'states.id')->where('country_id', $request->id )->get();
        return response()->json([
            'status' => true,
            'data' => $states
        ]);
    }
}
