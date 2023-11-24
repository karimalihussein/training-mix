<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Center;

class CenterDetailsController extends Controller
{
    public function index()
    {
        $file = public_path('Book176.xlsx');
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $sheetData = $sheet->toArray();

        $data = [];

        foreach ($sheetData as $key => $value) {
            if ($key > 0) {
                $data[] = $value[0].' '.$value[1];
            }
        }

        $data = json_decode(json_encode($data));

        foreach (array_count_values($data) as $key => $value) {
            $newData[] = [
                'name' => $key,
                'count' => $value,
            ];
        }

        $jsonData = public_path('json/centers/details/all.json');
        file_put_contents($jsonData, json_encode($newData));

        return 'done';

        // $data = array_chunk($data, 10000);

        // foreach ($data as $key => $value) {
        //     $jsonData = public_path('json/centers/details/data'.$key.'.json');
        //     file_put_contents($jsonData, json_encode($value));
        // }

        // return "done";

    }

    public function read()
    {
        $jsonData2 = public_path('/json/centers/details/all.json');
        $data2 = json_decode(file_get_contents($jsonData2), true);
        Center::insert($data2);

        return 'done';
        // Center

        // return $data2;

        // foreach (array_count_values($data2) as $key => $value) {
        //     $newData[] = [
        //         'name'   => $key,
        //         'count'  => $value
        //     ];
        // }
        // return $newData;
    }
}
