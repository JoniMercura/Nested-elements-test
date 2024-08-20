<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Resolvers\DomainTenantResolver;


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

    protected function getAzureConfig()
    {
        $config = [
            'client_id' => tenant()->azure_client_id,
            'client_secret' => tenant()->azure_client_secret,
            'redirect' => tenant()->azure_redirect_uri,
            'tenant' => tenant()->azure_tenant_id,
        ];
        
        return $config;
    }

    public function redirectToMicrosoft()
    {
        // Set Azure config for the current tenant
        config(['services.microsoft' => $this->getAzureConfig()]);

        return Socialite::driver('microsoft')->with(['tenant' => config('services.microsoft.tenant')])->redirect();
    }

    public function handleMicrosoftCallback()
    {
        try {
            // Set Azure config for the current tenant
            config(['services.microsoft' => $this->getAzureConfig()]);

            $microsoftUser = Socialite::driver('microsoft')->stateless()->user();

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
