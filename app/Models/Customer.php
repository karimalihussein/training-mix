<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'contract_at', 'active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'contract_at' => 'datetime',
        'active' => 'boolean',
    ];

    /**
     * Get the user that owns the customer.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

     /**
      * Get the customer's formatted contract date.
      *
      * @return array
      */
     public function format()
     {
         return [
             'customer_id' => $this->id,
             'name' => $this->name,
             'created_by' => $this->user->name,
             'active' => $this->active,
             'last_updated' => $this->updated_at->diffForHumans(),
         ];
     }
}
