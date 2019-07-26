<?php

namespace App\Http\Controllers\Country;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CountryModel;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{

    // get all countries and return in JSON format with code 200 for success
    public function country()
    {
        return response()->json(CountryModel::get(), 200);
    }

    // get country by parameter ID and return in JSON format with code 200 for success
    public function countryById($id)
    {
        $country = CountryModel::find($id);

        if (is_null($country)) {
            return response()->json(['message'=>'Record not found'], 404);
        }

        return response()->json(CountryModel::find($id), 200);
    }

    // add country by accepting POST request. It return code 201 for successfully created db entry
    public function countrySave(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'iso' => 'required|min:2|max:2'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $country = CountryModel::create($request->all());
        return response()->json($country, 201);
    }

    // update country by accepting PUT request and the model. Return the updated model entry with code 200 success
    public function countryUpdate(Request $request, $id)
    {
        $country = CountryModel::find($id);

        if (is_null($country)) {
            return response()->json(['message'=>'Record not found'], 404);
        }

        $country->update($request->all());
        return response()->json($country, 200);
    }


    // delete country by accepting DELETE request and the model for deletion.
    public function countryDelete($id)
    {
        $country = CountryModel::find($id);

        if (is_null($country)) {
            return response()->json(['message'=>'Record not found'], 404);
        }

        $country->delete();
        return response()->json(null, 204);
    }


}
