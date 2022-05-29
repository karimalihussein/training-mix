<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class UserReservationController extends Controller
{
    public function index() : AnonymousResourceCollection
    {
        abort_unless(auth()->user()->tokenCan('reservations.show'), Response::HTTP_FORBIDDEN, 'Unauthorized action.');

        // validation
        validator(request()->all(), [
                    'status'        =>  [Rule::in([Reservation::STATUS_ACTIVE, Reservation::STATUS_CANCELLED])],
                    'start_date'    =>  ['date', 'required_with:end_date'],
                    'end_date'      =>  ['date','required_with:start_date','after:start_date'],
                    'office_id'     =>  ['integer']
        ])->validate();

        $reservations = Reservation::query()
        ->where('user_id', auth()->id())
        ->when(request('office_id'), 
        fn($query) => $query->where('office_id', request('office_id'))
        )->when(request('status'), 
        fn($query) => $query->where('status', request('status'))
        // )->when(request('start_date') && request('end_date'),
        //     function($query){
        //         $query->whereBetween('start_date', [request('start_date'), request('end_date')])
        //         ->orWhereBetween('end_date', [request('start_date'), request('end_date')]);
        //     }
        )->when(request('start_date') && request('end_date'),
         function($query){
             $query->where(function($query){
                 return $query->whereBetween('start_date', [request('start_date'), request('end_date')])
                         ->orWhereBetween('end_date', [request('start_date'), request('end_date')]);
             });
         }
        // fn($query) => $query->whereBetween(request('start_date'), request('end_date'))
        )
        ->with(['office.featuredImage'])
        ->paginate(20);

        return ReservationResource::collection($reservations);
        
    }
}
