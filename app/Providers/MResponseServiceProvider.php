<?php

namespace App\Providers;

use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response as ResponseFacade;
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

        ResponseFacade::macro('handle', function (string $view, array $data, int $responseCode = Response::HTTP_OK, $exception = null) use ($self) {
            $response = request()->expectsJson() ?
                response()->json($self->normalizeJsonData($data, $responseCode, $exception)) :
                response()->view($view, $data);

            $response->setStatusCode($responseCode);

            if($action = $self->needRedirect($responseCode)) {
                return redirect()->action($action);
            }

            return $response;
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

        return array_merge(['success' => $code >= 200 && $code <= 299], $data);
    }

    /**
     * Detect current Controller and Action
     *
     * @return array
     */
    public function detectControllerAndAction() {
        $action = app('request')->route()->getAction();
        $controller = class_basename($action['controller']);

        return explode('@', $controller);
    }

    /**
     * Check is need to redirect user to index page
     *
     * @param int $responseCode
     * @return string|bool String like Controller@action or false if we don't need to redirect
     */
    public function needRedirect(int $responseCode) {
        list($controller, $action) = $this->detectControllerAndAction();

        $needRedirect =
            !request()->expectsJson() &&
            $responseCode == Response::HTTP_NO_CONTENT &&
            method_exists('App\Http\Controllers\\' . $controller, 'index');

        return $needRedirect ? implode('@', [$controller, 'index']) : false;
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
