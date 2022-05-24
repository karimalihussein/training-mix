<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImageResource;
use App\Models\Image;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class OfficeImageController extends Controller
{
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Office $office) : JsonResource
    {
    

        abort_unless(auth()->user()->tokenCan('office.update'),
        Response::HTTP_FORBIDDEN
         );

        $this->authorize('update', $office);


        request()->validate([
                      'image'       => ['required', 'image', 'max:2048', 'mimes:jpeg,png,jpg,gif,svg,webp,bmp,tiff,ico,svgz'],
         ]);

         $path = request()->file('image')->storePublicly('public/offices',['disk' => 'public']);
         $image =  $office->images()->create([
                'path'          => $path,
         ]);
         
         return ImageResource::make($image);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function delete(Office $office,Image $image)
    {
        // abort_if(auth()->user()->tokenCan('office.update'), Response::HTTP_FORBIDDEN, 'You are not allowed to update an office');
        // $this->authorize('update',$office);

        // throw_if($office->images()->count() == 1, 
        //         ValidationException::withMessages(['image' => ['The image does not belong to this office'],
        // ]));

        // throw_if($office->featured_image_id == $image->id, 
        //         ValidationException::withMessages(['image' => ['The image is the featured image of this office'],
        // ]));
        // Storage::disk('public')->delete($image->path);
        // $image->delete();


        abort_unless(auth()->user()->tokenCan('office.update'),
            Response::HTTP_FORBIDDEN
        );

        $this->authorize('update', $office);


        throw_if($image->resource_type != 'office' || $image->resource_id != $office->id, 
                ValidationException::withMessages(['image' => ['The image does not belong to this office'],
        ]));



        throw_if($office->images()->count() == 1,
            ValidationException::withMessages(['image' => 'Cannot delete the only image.'])
        );

        throw_if($office->featured_image_id == $image->id,
            ValidationException::withMessages(['image' => 'Cannot delete the featured image.'])
        );

        Storage::delete($image->path);

        $image->delete();
    
    }
}
