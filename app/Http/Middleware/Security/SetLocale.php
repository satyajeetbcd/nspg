<?php

namespace App\Http\Middleware\Security;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $supported = Config::get('locale.supported', []);
        $aliases   = Config::get('locale.aliases', []);
        $default   = Config::get('locale.default', 'en-SA');

        $incoming = $request->route('locale'); // from {locale} prefix

        // normalize: alias + proper-case aa-BB
        $normalized = $incoming;
        if (isset($aliases[$normalized])) {
            $normalized = $aliases[$normalized];
        }
        if ($normalized) {
            $parts = preg_split('/[-_]/', $normalized);
            $normalized = count($parts) === 2
                ? Str::lower($parts[0]).'-'.Str::upper($parts[1])
                : ($aliases[$normalized] ?? $default);
        }

        if (!preg_match('/^[a-z]{2}-[A-Z]{2}$/', $normalized) || ! in_array($normalized, $supported, true)) {
            $normalized = $default;
        }

        // lang folder uses underscore
        $folder = Str::of($normalized)->before('-')->toString();
        App::setLocale($folder);
        Session::put('locale', $normalized);

        // share direction and locale data to views

        $dir = Str::startsWith($normalized, 'ar-') ? 'rtl' : 'ltr';
        Config::set('app.text_dir', $dir);
        view()->share([
            'textDir' => $dir,
            'uiLocale' => $normalized,
            'currentLocale' => $normalized,
        ]);

        // make URL generator include {locale} automatically
        URL::defaults(['locale' => $normalized]);

        return $next($request);
    }
}
