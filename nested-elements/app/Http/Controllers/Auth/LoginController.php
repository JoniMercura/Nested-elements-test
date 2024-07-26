<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('vendor.backpack.base.auth.login');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();
        $this->loginOrCreateAccount($user, 'google');
        return redirect()->intended('admin/dashboard');
    }

    public function redirectToMicrosoft()
    {
        return Socialite::driver('microsoft')->redirect();
    }

    public function handleMicrosoftCallback()
    {
        $user = Socialite::driver('microsoft')->stateless()->user();
        $this->loginOrCreateAccount($user, 'microsoft');
        return redirect()->intended('admin/dashboard');
    }

    protected function loginOrCreateAccount($providerUser, $provider)
    {
        $user = User::where('email', $providerUser->getEmail())->first();

        if ($user) {
            $user->update([
                'provider' => $provider,
                'provider_id' => $providerUser->getId(),
            ]);
        } else {
            $user = User::create([
                'name' => $providerUser->getName(),
                'email' => $providerUser->getEmail(),
                'provider' => $provider,
                'provider_id' => $providerUser->getId(),
                'password' => '',
            ]);
        }

        backpack_auth()->login($user);
    }
}
