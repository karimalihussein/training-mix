<?php

namespace App\Providers;

use App\Http\Middleware\CasheResponeMiddleware;
use App\Mixins\StrMixins;
use App\PostcardSendingService;
use App\Services\CreditPaymentGatway;
use App\Services\PaymentGatway;
use App\Services\PaymentGatwayContract;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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
            if(request()->has('credit')) {
                return new CreditPaymentGatway(config('services.payment_gatway.currency'));
            }
            return new PaymentGatway(config('services.payment_gatway.currency'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(CasheResponeMiddleware::class);
        $this->app->singleton('Postcard', function ($app) {
            return new PostcardSendingService('us', 3,9);
        });

        // Str::macro('partNumber', function($part){
        //             return 'AB-' . substr($part, 0, 3) . '-' . substr($part,3);
        // });
        Str::mixin(new StrMixins());
        ResponseFactory::macro('errorJson', function($message = 'Default error message', $status = 400) {
            return [
                'message' => $message,
                'status' => $status
         
            ];
        });
    }
}
