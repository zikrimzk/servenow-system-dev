<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Geocoder\Geocoder;
use GuzzleHttp\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $client = new Client(['verify' => false]); // Disable SSL verification
        $geocoder = new Geocoder($client);

        $geocoder->setApiKey(env('GOOGLE_MAPS_GEOCODING_API_KEY', '')); // Set your Google Maps API key
        app()->instance(Geocoder::class, $geocoder);
    }
}
