<?php

namespace App\Http\Controllers;

use App\Models\User;
use Bpuig\Subby\Models\Plan;
use App\Models\Tenant\Tenant;
use App\Models\Tenant\Customer;
use App\Http\Controllers\Controller;
use App\Problemes\BearandBigBrother;
use Bpuig\Subby\Models\PlanSubscription;
use Nafezly\Payments\Classes\PaymobPayment;
use Nafezly\Payments\Classes\PayPalPayment;
use Rap2hpoutre\FastExcel\FastExcel;
class TestController extends Controller
{

    public function index()
    {
        $collection = (new FastExcel)->import('data.xlsx');
        return $collection;
       $file = public_path('data.xlsx');
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $sheetData = $sheet->toArray();

        dd($sheetData);

        $data = [];

        foreach ($sheetData as $key => $value) {
            if($key > 0){
                $data[] = $value[0];
            }
        }

         $data = json_decode(json_encode($data));
         $data = array_chunk($data, 10);
         return $data;

        // foreach (array_count_values($data) as $key => $value) {
        //     $newData[] = [
        //         'name'   => $key,
        //         'count'  => $value
        //     ];
        // }

        // // save new data to json file_put_contents
        // $file = public_path('centersFinal.json');
        // file_put_contents($file, json_encode($newData));

        // return $newData;

        // return $newData;
        // foreach ($newData as $key => $value) {
        //     $jsonData = public_path('json/centers/new/data'.$key.'.json');
        //     file_put_contents($jsonData, json_encode($value));
        // }

        // return "done";
    }

    
}
