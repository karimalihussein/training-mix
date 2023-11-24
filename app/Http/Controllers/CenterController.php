<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Jobs\CenterXlJob;
use App\Models\Center;

class CenterController extends Controller
{
    public function index()
    {
        $jsonData = public_path('centersFinal.json');
        $data = json_decode(file_get_contents($jsonData), true);

        Center::insert($data);

        return 'done';

    }

    public function checkData()
    {
        // $file = public_path('centers.xlsx');
        // $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        // $spreadsheet = $reader->load($file);
        // $sheet = $spreadsheet->getActiveSheet();
        // $sheetData = $sheet->toArray();

        // $data = [];

        // foreach ($sheetData as $key => $value) {
        //     if($key > 0){
        //         $data[] = $value[0];
        //     }
        // }

        //  $data = json_decode(json_encode($data));
        // //  $data = array_chunk($data, 100000);

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

    public function readfile()
    {
        $jsonData = public_path('json/centers/data0.json');
        $data = json_decode(file_get_contents($jsonData), true);

        foreach (array_count_values($data) as $key => $value) {
            $data2[] = [
                'name' => $key,
                'count' => $value,
            ];
        }

        return $data2;

        //    return $data2;

        $jsonData2 = public_path('json/centers/data1.json');
        $data2 = json_decode(file_get_contents($jsonData2), true);

        foreach (array_count_values($data2) as $key => $value) {
            $data3[] = [
                'name' => $key,
                'count' => $value,
            ];
        }

        // array push to another

    }

    public function storeData2()
    {
        $path = public_path('json/centers/');
        $files = glob($path.'*');
        foreach ($files as $file) {
            $data = array_map('str_getcsv', file($file));
            $data = json_decode(file_get_contents($file), true);

            foreach (array_count_values($data) as $key => $value) {
                $newData[] = [
                    'name' => $key,
                    'count' => $value,
                ];
            }

            CenterXlJob::dispatch($newData);
            unlink($file);
        }

        return 'done';

    }
}
