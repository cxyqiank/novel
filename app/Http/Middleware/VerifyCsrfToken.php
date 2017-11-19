<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/index',
        '/index-likeRead',
        '/index-notice',
        '/index-banner',
        '/index-hotRead',
        '/index-collect',
        '/index',
        '/shelf',
        '/hotAuthor',
        '/collectors',
        '/contentRead',
        '/user-login',
        '/user-register',
        '/user-sendMsg',
    ];
}
