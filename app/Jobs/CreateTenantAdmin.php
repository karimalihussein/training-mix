<?php

namespace App\Jobs;

use App\Models\Tenant;
use App\Models\Tenant\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateTenantAdmin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Tenant $tenant)
    {
        $tenant = $this->tenant;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->tenant->run(function($tenant){

                    User::create(
                                [
                                    'name' => $this->tenant->name,
                                    'email' => $this->tenant->email,
                                    'password' => $this->tenant->password,
                                    'phone_number' => $this->tenant->phone_number,
                                    'is_manager' => true,
                                ]
                            );

        });
    }
}





