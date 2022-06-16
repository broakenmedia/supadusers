<?php

namespace App\Providers;

use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\ServiceProvider;

class ApiResponseProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(ResponseFactory $factory)
    {
        $factory->macro('success', function (string $message = '', $data = null, int $statusCode = 200) use ($factory) {
            $format = [
                'success' => true,
                'message' => $message,
                'data' => $data,
            ];
            return $factory->make($format, $statusCode);
        });

        $factory->macro('failure', function (string $message = '', $errors = null, int $statusCode = 200) use ($factory) {
            $format = [
                'success' => false,
                'message' => $message,
                'errors' => $errors,
            ];
            return $factory->make($format, $statusCode);
        });
    }
}
