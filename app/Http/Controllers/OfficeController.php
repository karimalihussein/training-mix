<?php

namespace App\Http\Controllers;

use App\Http\Resources\OfficeResource;
use App\Models\Office;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Validators\OfficeValidator;
use App\Notifications\OfficePendingApproval;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class OfficeController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $offices = Office::query()
            ->when(request('user_id') && auth()->user() && request('user_id') == auth()->id(),
                fn ($builder) => $builder,
                fn ($builder) => $builder->where('approval_status', Office::APPROVAL_APPROVED)->where('hidden', false))
            ->when(request('user_id'), fn ($builder) => $builder->whereUserId(request('user_id')))
            ->when(request('visitor_id'),
                fn (Builder $builder) => $builder->whereRelation('reservations', 'user_id', '=', request('visitor_id'))

            )
            ->when(
                request('lat') && request('lng'),
                fn (Builder $builder) => $builder->nearestTo(request('lat'), request('lng')),
                fn (Builder $builder) => $builder->orderBy('id', 'desc')
            )
            ->with(['images', 'tags', 'user'])
            ->withCount(['reservations' => fn (Builder $builder) => $builder->where('status', Reservation::STATUS_ACTIVE)]
            )
            ->get();

        return OfficeResource::collection($offices);
    }

    public function show(Office $office): OfficeResource
    {
        $office->loadCount(['reservations' => fn (Builder $builder) => $builder->where('status', Reservation::STATUS_ACTIVE)]
        )->load(['images', 'tags', 'user', 'reservations']);

        return OfficeResource::make($office);
    }

    public function store(): JsonResource
    {
        if (! auth()->user()->tokenCan('office.create')) {
            abort(Response::HTTP_FORBIDDEN, 'You are not allowed to create an office');
        }

        $attributes = (new OfficeValidator())->validate($office = new Office(), request()->all());

        $attributes['approval_status'] = Office::APPROVAL_PENDING;
        $attributes['user_id'] = auth()->user()->id;

        $office = DB::transaction(function () use ($office, $attributes) {
            $office->fill(
                Arr::except($attributes, ['tags'])
            )->save();
            if (isset($attributes['tags'])) {
                $office->tags()->attach($attributes['tags']);
            }

            return $office;
        });

        Notification::send(User::where('is_admin', true)->get(), new OfficePendingApproval($office));

        return OfficeResource::make(
            $office->load(['tags', 'images', 'user'])
        );

    }

    public function update(Office $office): JsonResource
    {
        if (! auth()->user()->tokenCan('office.update')) {
            abort(Response::HTTP_FORBIDDEN, 'You are not allowed to update an office');
        }

        $this->authorize('update', $office);

        $attributes = (new OfficeValidator())->validate($office, request()->all());

        $office->fill(Arr::except($attributes, ['images', 'tags']));

        if ($requireReview = $office->isDirty(['lng', 'lat', 'price_per_day'])) {
            $office->fill(['approval_status' => Office::APPROVAL_PENDING]);
        }

        DB::transaction(function () use ($office, $attributes) {
            $office->update(
                Arr::except($attributes, ['tags'])
            );

            if (isset($attributes['tags'])) {
                $office->tags()->sync($attributes['tags']);
            }
        });

        if ($requireReview) {
            Notification::send(User::where('is_admin', true)->get(), new OfficePendingApproval($office));
        }

        return OfficeResource::make(
            $office->load(['tags', 'images', 'user'])
        );
    }

    public function delete(Office $office)
    {
        if (! auth()->user()->tokenCan('office.delete')) {
            abort(Response::HTTP_FORBIDDEN, 'You are not allowed to update an office');
        }

        $this->authorize('delete', $office);

        throw_if(
            $office->reservations()->where('status', Reservation::STATUS_ACTIVE)->exists(),
            ValidationException::withMessages(['office' => 'Cannot delete this office!'])
        );
        $office->images()->each(function ($image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        });

        $office->delete();
    }
}
