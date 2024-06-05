<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FlaskService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.flask.base_url');
    }

    public function predict(array $texts)
    {
        $response = Http::post("{$this->baseUrl}/predict", [
            'texts' => $texts,
        ]);

        return $response->json();
    }
}
