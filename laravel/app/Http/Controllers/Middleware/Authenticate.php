<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        // expectsJsonの場合はリダイレクトせず401を返す
         if (! $request->expectsJson()) {
              return route('api.login');
          }
        // expectsJsonの場合はnullを返す（リダイレクトしない）
        return null;
    }
}

