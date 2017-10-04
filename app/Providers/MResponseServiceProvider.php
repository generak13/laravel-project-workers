<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;

class MResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $self = $this;

        Response::macro('handle', function (string $view, array $data, int $responseCode = 200, $exception = null) use ($self) {
            $response = request()->expectsJson() ?
                response()->json($self->normalizeJsonData($data, $responseCode, $exception)) :
                response()->view($view, $data);

            return $response->setStatusCode($responseCode);
        });
    }

    /**
     * Normalize response for json format
     * @param array $data
     * @param int $code
     * @param \Exception $exception
     * @return array
     */
    public function normalizeJsonData(array $data, int $code, \Exception $exception = null) {
        if($exception instanceof ValidationException) {
            $data = ['message' => 'Data is not valid'];
        }

        return array_merge(['success' => $code == 200], $data);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
