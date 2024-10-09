<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Elastic\Elasticsearch\ClientBuilder;
class TestController extends Controller
{
    public function __invoke()
    {
//         $params = [
//             'index' => 'my_index',
//             'id'    => '1',
//             'body'  => [
//                 'title' => 'Elasticsearch in Laravel',
//                 'content' => 'This is an example of integrating Elasticsearch with Laravel.'
//             ]
//         ];

                $client = ClientBuilder::create()
            ->setHosts(['https://localhost:9200/'])
            ->setApiKey('b01Ra2FKRUJQLUFWdGtfOFh4TzA6MDM2NEw1d2NTQy1pd3lzY1RsNUpUdw==')
            ->setSSLVerification(false)  // Disable SSL verification
            ->build();

//           $client->index($params);

        // $response = $this->elasticsearch->index($params);
        // return $response;

         $params = [
             'index' => 'my_index',
             'body'  => [
                 'query' => [
                     'match' => [
                         'title' => 'Elasticsearch'
                     ]
                 ]
             ]
         ];

         return $client->search($params);

        // $response = $this->elasticsearch->search($params);
        // return $response['hits']['hits'];


//        $response = $client->info();
////        echo $response->getStatusCode();
////        echo (string) $response->getBody();
//
//        return [
//            'status' => $response->getStatusCode(),
//            'body' => (string) $response->getBody()
//        ];

    }
}
