<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\User;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $folder = Folder::first();
        $user = User::first();
        $folder
            ->addMediaFromRequest('image')
            ->sanitizingFileName(function ($fileName) {
                return strtolower(str_replace(['#', '/', '\\', ' '], '-', $fileName));
            })
            ->usingFileName(time().'.'.$request->file('image')->getClientOriginalExtension())
            ->toMediaCollection('folders');
    }
}
