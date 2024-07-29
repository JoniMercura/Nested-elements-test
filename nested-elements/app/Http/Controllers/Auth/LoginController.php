<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $this->loginOrCreateAccount($user, 'google');
            return redirect()->intended('admin/dashboard');
        } catch (\Exception $e) {
            Log::error('Exception: ' . $e->getMessage());
            return redirect('/admin')->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function redirectToMicrosoft()
    {
        return Socialite::driver('microsoft')->redirect();
    }

    public function handleMicrosoftCallback()
    {
        try {
            $microsoftUser = Socialite::driver('microsoft')->stateless()->user();

            // Check if the user's email domain matches the company's domain
            $companyDomain = 'mercura.dk';
            if (explode('@', $microsoftUser->getEmail())[1] !== $companyDomain) {
                throw new \Exception('Unauthorized email domain.');
            }

            $user = $this->loginOrCreateAccount($microsoftUser, 'microsoft');
            return redirect()->intended('admin/dashboard');
        } catch (\Exception $e) {
            Log::error('Exception: ' . $e->getMessage());
            return redirect('/admin')->with('error', 'Something went wrong. Please try again.');
        }
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
