<?php

namespace App\Models;

use App\Traits\HasSubscription;
use Devinweb\LaravelHyperpay\Traits\ManageUserTransactions;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, ManageUserTransactions, HasRoles, HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'employee_type',
        'start_date',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
        'password' => 'hashed'
    ];

    /**
     * appends to the attributes array
     */
    protected $appends = [
        // 'salary',
    ];

    /**
     * Image relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function name(): Attribute
    {
        return new Attribute(
            get: fn ($value) => strtoupper($value),
            set: fn ($value) => $value,
        );
    }

    /**
     * Calculate the salary of the user
     *
     * @var float
     */
    public function getSalaryAttribute(): float
    {
        $positions = [
            'developer' => 'App\\Calculators\\DeveloperSalaryCalculator',
            'manager' => 'App\\Calculators\\ManagerSalaryCalculator',
            'sales' => 'App\\Calculators\\SalesSalaryCalculator',
        ];

        return (new $positions[$this->employee_type])->calculate($this->start_date);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function offices()
    {
        return $this->hasMany(Office::class);
    }

    public function passwordHistories()
    {
        return $this->hasMany(PasswordHistory::class)->latest();
    }

    /**
     * get a random profile image
     */
    public function profile()
    {
        return 'https://xsgames.co/randomusers/avatar.php?g=male';
    }

    public function logins()
    {
        return $this->hasMany(Login::class);
    }

    // public function scopeWithLastLoginAt($query)
    // {
    //     $query->addSelect(['last_login_at' => Login::select('created_at')
    //     ->whereColumn('user_id', 'users.id')
    //     ->latest()
    //     ->limit(1)
    //     ])
    //     ->withCasts([
    //         'last_login_at' => 'datetime',
    //     ]);
    // }

    // public function scopeWithLastLoginIpAddress($query)
    // {
    //     $query->addSelect(['last_login_ip_address' => Login::select('ip_address')
    //     ->whereColumn('user_id', 'users.id')
    //     ->latest()
    //     ->limit(1)
    //     ]);
    // }

    public function lastLogin()
    {
        return $this->belongsTo(Login::class);

    }

    public function scopeWithLastLogin($query)
    {
        $query->addSelect(['last_login_id' => Login::select('id')
            ->whereColumn('user_id', 'users.id')
            ->latest()
            ->take(1),
        ])->with('lastLogin');
    }

    /**
     * Get the name of the index associated with the model.
     */
    public function searchableAs(): string
    {
        return 'users_index';
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
