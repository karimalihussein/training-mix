<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Middleware\CasheResponeMiddleware;
use App\Mixins\StrMixins;
use App\Models\Folder;
use App\Models\Office;
use App\Models\Post;
use App\Models\Series;
use App\Models\Step;
use App\Models\Tenant\Customer;
use App\Models\Tenant\Tenant;
use App\Models\User;
use App\PostcardSendingService;
use App\Services\CreditPaymentGatway;
use App\Services\PaymentGatway;
use App\Services\PaymentGatwayContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Cashier\Cashier;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Facades\Health;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Checks\Checks\CpuLoadCheck;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PaymentGatwayContract::class, function ($app) {
            // return new PaymentGatway(config('services.payment_gatway.currency'));
            // return new CreditPaymentGatway(config('services.payment_gatway.currency'));
            if (request()->has('credit')) {
                return new CreditPaymentGatway(config('services.payment_gatway.currency'));
            }

            return new PaymentGatway(config('services.payment_gatway.currency'));
        });

       // Health::checks([
           // UsedDiskSpaceCheck::new()
               // ->warnWhenUsedSpaceIsAbovePercentage(70)
             //   ->failWhenUsedSpaceIsAbovePercentage(90),

           // DatabaseCheck::new(),
           // CpuLoadCheck::new(),

//        ]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::unguard();
        Model::preventLazyLoading(!app()->isProduction());
        Model::handleLazyLoadingViolationUsing(
            fn ($model, $relation) => Logger("Lazy loading violation: {$model} {$relation}")
        );
        $this->app->singleton(CasheResponeMiddleware::class);
        $this->app->singleton('Postcard', function ($app) {
            return new PostcardSendingService('us', 3, 9);
        });

        // Str::macro('partNumber', function($part){
        //             return 'AB-' . substr($part, 0, 3) . '-' . substr($part,3);
        // });
        Str::mixin(new StrMixins());
        ResponseFactory::macro('errorJson', function ($message = 'Default error message', $status = 400) {
            return [
                'message' => $message,
                'status' => $status,

            ];
        });

        Relation::enforceMorphMap([
            'office' => Office::class,
            'user' => User::class,
            'post' => Post::class,
            'step' => Step::class,
            'series' => Series::class,
            'folder' => Folder::class,
            'customer' => Customer::class,
            'tenant' => Tenant::class
        ]);
        Gate::define('admin', fn (User $user) => $user->is_admin);
        Blade::if('admin', fn () => auth()->user()?->can('admin'));
        Cashier::useCustomerModel(User::class);
        Cashier::calculateTaxes();
        // Http::macro('github', fn() => Http::withHeaders(['X-Example' => 'example'])->baseUrl('https://github.com'));
        // https://www.arbeitnow.com/api/job-board-api
        Http::macro('arbeitnow', fn () => Http::withHeaders(['X-Example' => 'example'])->baseUrl('https://www.arbeitnow.com/api/job-board-api'));
    }
}
