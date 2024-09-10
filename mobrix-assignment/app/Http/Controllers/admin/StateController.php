<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StateController extends Controller
{
    public function create(){
        $countries = Country::orderby('country_name', 'ASC')->get();
        $states = State::select("states.*", "countries.country_name")
        ->orderBy('state_name', 'ASC')
        ->leftJoin("countries", "countries.id", "=", "states.country_id")
        ->get();
        $data['states'] = $states;
        $data['countries'] = $countries;
        return view('admin.state.create', $data);
    }

    public function store(Request $request){
        // dd($request->all());
        $validate = Validator::make($request->all(),[
            'name' => 'required|string',
            'country' => 'required',
            'status' => 'required' 
        ]);

        if($validate->passes()){

            $state = new State();
            $state->state_name = $request->name;
            $state->country_id = $request->country;
            $state->status = $request->status;
            $state->save();

            return response()->json([
                'status' => true,
                'message' => 'State created'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validate->errors()
            ]);
        }
    }

    public function edit($id){
        $countries = Country::orderby('country_name', 'ASC')->get();
        $state = State::find($id);
        // dd($states);
        $data['state'] = $state;
        $data['countries'] = $countries;
        return view('admin.state.edit',$data);
    }

    public function update($id, Request $request){
        $state = State::find($id);
        $validate = Validator::make($request->all(),[
            'name' => 'required|string',
            'country' => 'required',
            'status' => 'required' 
        ]);

        if($validate->passes()){
            $state->state_name = $request->name;
            $state->country_id = $request->country;
            $state->status = $request->status;
            $state->save();

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
        $state = State::find($id);
        $state->delete();

        return redirect()->route('state.create');
    }
}
