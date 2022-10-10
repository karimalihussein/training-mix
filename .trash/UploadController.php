<?php

namespace App\Http\Controllers;

use App\Jobs\PeopleXlJob;
use App\Jobs\SalesCsvProcess;
use App\Models\Sale;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }


    public function index()
    {
        return view('uploads-file');
    }

    public function store(Request $request)
    {

    

        // $data = array_map('str_getcsv', file($request->csv));
        $data = file($request->csv);
        $header = $data[0];
        unset($data[0]);

        $chunks = array_chunk($data, 1000);

        // file_put_contents(storage_path('app/public/sales.csv'), '');

        foreach ($chunks as $key => $value)
        {
            $number = time();
            $name =  "$number-$key.csv";
            $path = public_path("cvs/$name");
            file_put_contents($path, $value);
        }
        return "done";
        
  
        foreach($data as $item)
        {
            // $sale =  array_combine($header, $item);
            // Sale::create($sale);

            Sale::create([
                'region' => $item[0],
                'country' => $item[1],
                'item_type' => $item[2],
                'sales_channel' => $item[3],
                'order_priority' => $item[4],
                'order_date' => $item[5],
                'order_id' => $item[6],
                'ship_date' => $item[7],
                'units_sold' => $item[8],
                'unit_price' => $item[9],
                'unit_cost' => $item[10],
                'total_revenue' => $item[11],
                'total_cost' => $item[12],
                'total_profit' => $item[13],
            ]);
        }


        
        return "works";




        // $request->validate([
        //     'file' => 'required|file|max:1024',
        // ]);

        // $file = $request->file('file');
        // $file->store('public');

        return back()->with('success', 'You have successfully upload file.');
    }

    public function storeData()
    {
       
        $path = public_path('cvs/');
        $files = glob($path . "*");
        foreach ($files as $file) {
                $data = array_map('str_getcsv', file($file));
                SalesCsvProcess::dispatch($data, $this->fillables());
                unlink($file);
        }
    
    }

    public function fillables()
    {
        $fillables = [
            'region',
            'country',
            'item_type',
            'sales_channel',
            'order_priority',
            'order_date',
            'order_id',
            'ship_date',
            'units_sold',
            'unit_price',
            'unit_cost',
            'total_revenue',
            'total_cost',
            'total_profit',
        ];
        return $fillables;
    }


    public function storeData2()
    {
        $path = public_path('json/test/');
        $files = glob($path . "*");
        foreach ($files as $file) {
            $data = array_map('str_getcsv', file($file));
            $data = json_decode(file_get_contents($file), true);
            PeopleXlJob::dispatch($data);
            unlink($file);
        }

        return "done";
       
    }
        
        
}

