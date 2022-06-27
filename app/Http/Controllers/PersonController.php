<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function index()
    {



       $data = array_chunk($data, 10);
       foreach ($data2 as $key => $value) {
           // $jsonData = public_path('json/people/data'.$key.'.json');
           // file_put_contents($jsonData, json_encode($value));
           $array[] = $key;
       }

       return $array;


        // $total = Person::select(['gender'])->pluck('gender')->toArray();
        //
        // foreach (array_count_values($total) as $key => $value) {
        //     $data3[] = [
        //         'name'   => $key,
        //         'count'  => $value
        //     ];
        // }
        //
        // return $data3;
        //
        //
        //
        //
        //
        // $male = $total->where('gender', 'male')->count();
        //
        // return $male;
        // $male = Person::where('gender', 'male')->count();
        // $female = Person::where('gender', 'female')->count();
        // $unknown = Person::where('gender', 'unknown')->count();
        // $total = $male; + $female; + $unknown;

        return [
                    'Total'     => $total,
                    'Female' => $female,
                    'Male' => $male,
                    'Unknown' => $unknown
        ];

    }
}
