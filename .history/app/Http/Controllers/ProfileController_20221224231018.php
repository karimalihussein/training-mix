<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        // create folder
        $folder = Folder::create([
            'user_id' => auth()->id(),
            'name' => 'My Folder',
            'color' => 'red',
            'icon' => 'folder',
            'type' => 'folder',
            'is_public' => false,
        ]);

    }
}
