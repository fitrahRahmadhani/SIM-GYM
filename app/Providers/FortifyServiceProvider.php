<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::loginView(function () {
            return Inertia::render('Auth/Login',[
                'logo'=>asset('assets/img/zeus 2.png')
            ]);
        });

        Fortify::registerView(function () {
            return Inertia::render('Auth/Register',[
                'logo'=>asset('assets/img/zeus 2.png')
            ]);
        });

        Fortify::resetPasswordView(function () {
            return Inertia::render('Auth/ResetPassword');
        });

        Fortify::verifyEmailView(function () {
            return Inertia::render('Auth/VerifyEmail',[
                'status'=> session('status'),
                'logo'=>asset('assets/img/zeus 2.png')
            ]);
        });

        Fortify::requestPasswordResetLinkView(function () {
            return Inertia::render('Auth/ForgotPassword',[
                'status'=> session('status'),
                'logo'=>asset('assets/img/zeus 2.png')
            ]);
        });

        Fortify::resetPasswordView(function (Request $request) {
            return Inertia::render('Auth/ResetPassword', [
                'request' => $request,
                'token'=>$request->route('token'),
                'logo'=>asset('assets/img/zeus 2.png')
            ]);
        });

    }
}
