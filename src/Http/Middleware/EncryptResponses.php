<?php

namespace UsmanAhmed\LaravelResponseEncryption\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use UsmanAhmed\LaravelResponseEncryption\Facades\ResponseEncryption;
use Symfony\Component\HttpFoundation\Response;

class EncryptResponses
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Skip if encryption is globally disabled
        if (ResponseEncryption::isDisabled()) {
            return $response;
        }

        // Skip if route is in except list
        if ($this->shouldExcludeRoute($request)) {
            return $response;
        }

        // Skip if not encryptable content type
        if (!in_array(
            $response->headers->get('Content-Type'),
            config('response-encryption.content_types', ['application/json'])
        )) {
            return $response;
        }

        $content = $response->getContent();

        if (empty($content)) {
            return $response;
        }

        try {
            $encrypted = ResponseEncryption::encrypt($content);
            $response->setContent(json_encode([
                'encrypted' => $encrypted
            ]));

            $response->headers->set('Content-Type', 'application/json');
            return $response;
        } catch (\Exception $e) {
            return $response;
        }
    }

    protected function shouldExcludeRoute(Request $request): bool
    {
        $excludedRoutes = config('response-encryption.except', []);

        foreach ($excludedRoutes as $route) {
            if ($request->is($route)) {
                return true;
            }
        }

        return false;
    }
}