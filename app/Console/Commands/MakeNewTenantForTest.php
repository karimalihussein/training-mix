<?php

namespace App\Console\Commands;

use App\Models\Tenant\Tenant;
use App\Models\Tenant\Customer;
use Bpuig\Subby\Models\Plan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User as CenteralUser;
use Illuminate\Support\Facades\Artisan;
use App\Models\Tenant\User as TenantUser;

class MakeNewTenantForTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:tenant';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make new tenant for test';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::statement('DROP DATABASE IF EXISTS `tenant'. 1 .'`');
        Artisan::call('migrate:fresh --seed');
        $customer = Customer::query()->create([
            'name' => 'Test Customer',
            'email' => 'test@gmail.com',
            'phone_number' => '123456789',
            'customer_at' => now(),
            'company_code' => 1234,
            'user_id' => CenteralUser::factory()->create()->id,
            'contract_at' => now(),
            'active' => true,
        ]);
        $tenant = Tenant::create([
            'domain' => 'test.'.env('CENTERAL_DOMAIN_URL'),
        ]);
        $tenant->createDomain(['domain' => $tenant->domain]);
        $customer->update([
            'tenant_id' => $tenant->id,
            'customer_at' => now(),
        ]);
        $tenant->newSubscription('main', Plan::find(4) , 'Main subscription', 'Customer main subscription', now(), 'paid');
        $tenant->run(function ($tenant) {
            TenantUser::query()->create([
                'name' => 'Test User',
                'email' => 'test@gmail.com',
                'password' => 'password',
            ]);
        });

        $customer2 = Customer::query()->create([
            'name' => 'Test Customer 2',
            'email' => 'test2@gmail.com',
            'phone_number' => '01292993312',
            'customer_at' => now(),
            'company_code' => 4321,
            'user_id' => CenteralUser::factory()->create()->id,
            'contract_at' => now(),
            'active' => true,
        ]);
        $tenant2 = Tenant::query()->create([
            'domain' => 'free.'.env('CENTERAL_DOMAIN_URL'),
        ]);
        $tenant2->createDomain(['domain' => $tenant2->domain]);
        $customer2->update([
            'tenant_id' => $tenant2->id,
            'customer_at' => now(),
        ]);
        $tenant2->newSubscription('main', Plan::find(1) , 'Main subscription', 'Customer main subscription', now(), 'free');
        $tenant->run(function ($tenant) {
            TenantUser::query()->create([
                'name' => 'Test User 2',
                'email' => 'test2@gmail.com',
                'password' => 'password',
            ]);
        });
        $this->info('New Company created successfully.');
    }
}
