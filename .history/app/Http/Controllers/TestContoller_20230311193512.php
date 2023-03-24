<?php

namespace App\Http\Controllers;

use App\Models\GeneralSettings;
use App\Models\Office;
use App\Models\Person;
use App\Models\Post;
use App\Models\User;
use App\Notifications\OfficePendingApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use GenderApi\Client as GenderApiClient;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Http;
use ParagonIE\Sodium\Core\Curve25519\H;
use Meilisearch\Client;
use Nafezly\Payments\Classes\PaymobPayment;

class TestContoller extends Controller
{
    public function __invoke()
    {
        $payment = new PaymobPayment();
        $payment->pay(
            100, 
            $user_id = null, 
            $user_first_name = null, 
            $user_last_name = null, 
            $user_email = null, 
            $user_phone = null, 
            $source = null
        );
        
        $client = new Client('http://localhost:7700', 'masterKey');
        return $client->getKeys();
    // Post::factory(100)->create();
    // Post::factory()->create([
    //     'title' => 'karim',
    //     'content' => 'karim',
    // ]);
    // return Post::search('karim')->get();
















        $admins = User::factory(100)->create();
        return "done";
        $genders = ['male', 'female'];

  
       $jsonData = public_path('json/test/data0.json');
       $data = json_decode(file_get_contents($jsonData), true);

       foreach ($data as $key => $value) {
            // $apiClient = new GenderApiClient('8PQXe8d5LEVwaFwLXB5JcUKKmfP32CnlVFSW');
            // $lookup = $apiClient->getByFirstNameAndLastNameAndCountry($value, 'egypt');
            //  $all[] = [
            //     'name'  => $value,
            //     'gender'    => $genders[rand(0, 1)],
            //  ];
             
            //  info([
            //         'name'  => $value,
            //         'gender' => $genders[rand(0, 1)],
            //  ]);

            Person::create([
                    'name'  => $value,
                    'gender' => $genders[rand(0, 1)]
            ]);
            

         }

         // unlink file
         unlink($jsonData);





         return "done";

       



    //    $apiClient = new GenderApiClient('8PQXe8d5LEVwaFwLXB5JcUKKmfP32CnlVFSW');

        // $lookup = $apiClient->getByFirstNameAndLastNameAndCountry('sara', 'egypt');

        // return $lookup->getGender();








    // //    return $lookup->getGender();

    //     // read xlsx file and convert it to json
        $file = public_path('09.xlsx');


        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $sheetData = $sheet->toArray();

        $data = [];

        foreach ($sheetData as $key => $value) {
            if($key > 0){
                $data[] = $value[0];
            }
        }



        // return json_encode($data);

         $data = json_decode(json_encode($data));

         $data = array_chunk($data, 250);




        // save every 1000 rows to json file in public folder

        foreach ($data as $key => $value) {
            $jsonData = public_path('json/data'.$key.'.json');
            file_put_contents($jsonData, json_encode($value));
        }

        return "done";

















    }
}
