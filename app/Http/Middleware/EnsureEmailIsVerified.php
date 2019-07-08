<?php

namespace App\Http\Middleware;

use Closure;

class EnsureEmailIsVerified
{
    public function handle($request, Closure $next)
    {
        //三个判断
        //1.如果用户已登录
        //2.且还未认证Email
        //3.并且访问的不是email验证相关url或者退出的url
        if ($request->user() &&
            ! $request->user()->hasVerifiedEmail() &&
            ! $request->is('email/*', 'logout')) {
            // 根据客户端返回对应的内容
            return $request->expectsJson()
                        ? abort(403, 'Your email address is not verified.')
                        : redirect()->route('verification.notice');
        }
        return $next($request);
    }
}
