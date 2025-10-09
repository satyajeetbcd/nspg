<?php

namespace App\Http\Middleware\Security;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class XSSProtection
{
    /**
     * Handle an incoming request and sanitize input data.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $input = $request->all();

        // Recursively sanitize all input data
        $sanitized = $this->sanitizeInput($input);

        // Replace request data with sanitized version
        $request->replace($sanitized);

        return $next($request);
    }

    /**
     * Recursively sanitize input data to prevent XSS attacks.
     *
     * @param array|string $input
     * @return array|string
     */
    private function sanitizeInput($input)
    {
        if (is_array($input)) {
            return array_map([$this, 'sanitizeInput'], $input);
        }

        if (is_string($input)) {
            // Remove script tags and dangerous HTML
            $input = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/i', '', $input);

            // Remove javascript: protocol
            $input = preg_replace('/javascript:/i', '', $input);

            // Remove on* event handlers
            $input = preg_replace('/\s*on\w+\s*=\s*["\'][^"\']*["\']/i', '', $input);

            // Strip dangerous HTML tags but preserve safe formatting
            $input = strip_tags($input, '<p><br><strong><em><u><ol><ul><li><a><img>');

            // Escape any remaining HTML entities
            $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8', false);
        }

        return $input;
    }
}
