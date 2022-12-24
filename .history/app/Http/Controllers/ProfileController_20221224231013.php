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
            'user_id' => $request->user()->id,
            'name' => $request->name,
            'color' => $request->color,
            'icon' => $request->icon,
            'type' => $request->type,
            'is_public' => $request->is_public,
        ]); 
    }
}
