<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebscrapingController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $client = new \Goutte\Client();
        $crawler = $client->request('GET', 'https://syarah.com/en/cars/used-cars');

        // clas name searchResultContainer
        $crawler->filter('.allCarsResult')->each(function ($node) {

        });
    }
}
