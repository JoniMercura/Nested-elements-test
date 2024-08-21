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
use App\Services\AzureKeyVaultService;


class LoginController extends Controller
{

    protected $keyVaultService;

    public function __construct(AzureKeyVaultService $keyVaultService)
    {
        $this->keyVaultService = $keyVaultService;
    }

    protected function getGoogleConfig()
    {
        $companyName = tenant()->company->name;

        // Get Google secrets from Azure Key Vault
        $config = [
            'client_id' => $this->keyVaultService->getSecret($companyName, 'GoogleClientID'),
            'client_secret' => $this->keyVaultService->getSecret($companyName, 'GoogleClientSecret'),
            'redirect' => $this->keyVaultService->getSecret($companyName, 'GoogleRedirectURI'),
        ];

        return $config;
    }

    public function redirectToGoogle()
    {
        // Set Azure config for the current tenant
        config(['services.google' => $this->getGoogleConfig()]);

        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            // Set Azure config for the current tenant
            config(['services.google' => $this->getGoogleConfig()]);

            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = $this->loginOrCreateAccount($googleUser, 'google');

            return redirect()->intended('admin/dashboard');

        } catch (\Exception $e) {
            Log::error('Exception: ' . $e->getMessage());
            return redirect('/admin')->with('error', 'Something went wrong. Please try again.');
        }
    }

    protected function getAzureConfig()
    {
        $companyName = tenant()->company->name;  // Get the ID of the current tenant

        // Get secrets from Azure Key Vault
        $config = [
            'client_id' => $this->keyVaultService->getSecret($companyName, 'ClientID'),
            'client_secret' => $this->keyVaultService->getSecret($companyName, 'ClientSecret'),
            'redirect' => $this->keyVaultService->getSecret($companyName, 'RedirectURI'),
            'tenant' => $this->keyVaultService->getSecret($companyName, 'TenantID'),
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
