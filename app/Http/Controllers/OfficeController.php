<?php

namespace App\Http\Controllers;

use App\Http\Resources\OfficeResource;
use App\Models\Office;
use App\Models\Reservation;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\Rule;

class OfficeController extends Controller
{
    
    public function index() : AnonymousResourceCollection
    {
        $offices = Office::query()
        ->where('approval_status', Office::APPROVAL_APPROVED)
        ->where('hidden', false)
        ->when(request('user_id'), fn($builder) => $builder->whereUserId(request('user_id')))
        ->when(request('visitor_id'), 
        fn(Builder $builder) 
            => $builder->whereRelation('reservations', 'user_id', '=', request('visitor_id'))
        
        )
        ->when(
            request('lat') && request('lng'),
            fn(Builder $builder) => $builder->nearestTo(request('lat'), request('lng')),
            fn(Builder $builder) => $builder->orderBy('id', 'desc')
        )   
        
         ->with(['images', 'tags', 'user'])
         ->withCount(['reservations' =>
         fn(Builder $builder) 
            => $builder->where('status', Reservation::STATUS_ACTIVE)]
         ) 
        ->get();
        return OfficeResource::collection($offices);
    }


    public function show(Office $office) : OfficeResource
    {
       $office->loadCount(['reservations' =>
        fn(Builder $builder) 
           => $builder->where('status', Reservation::STATUS_ACTIVE)]
        )->load(['images', 'tags', 'user', 'reservations']);
        return OfficeResource::make($office);
    }


    public function store() : JsonResource
    {
        $attributes = validator(request()->all(),
        [
            'title'           =>     ['required', 'string'],
            'description'     =>     ['required', 'string'],
            'address'         =>     ['required', 'string'],
            'lat'             =>     ['required', 'numeric'],
            'lng'             =>     ['required', 'numeric'],
            'address_line1'   =>     ['required', 'string'],
            'address_line2'   =>     ['nullable', 'string'],
            'hidden'          =>     ['required', 'boolean'],
            'price_per_Day'   =>     ['required', 'integer', 'min:100'],
            'monthly_discount'=>    ['nullable', 'integer', 'min:0'],
            'tags'            =>     ['required', 'array',],
            'tags.*'          =>     ['required', 'integer', Rule::exists('tags', 'id')],

            // 'description' => 'required|string|max:255',
            // 'address' => 'required|string|max:255',
            // 'lat' => 'required|numeric',
            // 'lng' => 'required|numeric',
            // 'user_id' => 'required|exists:users,id',
            // 'images' => 'required|array',
            // 'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'tags' => 'required|array',
            // 'tags.*' => 'required|string|max:255',
        ])->validate();

        return $attributes;
       
    }
   
}
