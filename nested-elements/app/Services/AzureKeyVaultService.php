<?php

namespace App\Services;

use GuzzleHttp\Client;

class AzureKeyVaultService
{
    protected $client;
    protected $vaultUrl;
    protected $accessToken;

    public function __construct()
    {
        $vaultName = 'MercuraVaultTest';
        $this->vaultUrl = "https://{$vaultName}.vault.azure.net/";
        $this->client = new Client();
        $this->accessToken = $this->getAccessToken();
    }

    protected function getAccessToken()
    {
        $tenantId = 'c7bf80c1-b827-4a8d-b129-ad70da49ae24'; // Azure Tenant ID
        $clientId = '38b1166e-67b8-483a-8647-5746c54b8dfe'; // Azure Client ID
        $clientSecret = 'RBV8Q~9pibbRc3JdbdkV9.oYsx8AIhtRY9xsqdnI'; // Azure Client Secret

        $response = $this->client->post("https://login.microsoftonline.com/{$tenantId}/oauth2/v2.0/token", [
            'form_params' => [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'scope' => 'https://vault.azure.net/.default',
                'grant_type' => 'client_credentials',
            ],
        ]);

        $body = json_decode($response->getBody()->getContents(), true);
        return $body['access_token'];
    }

    public function getSecret($tenantId, $secretName)
    {
        $response = $this->client->get("{$this->vaultUrl}secrets/{$tenantId}-{$secretName}?api-version=7.0", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
            ],
        ]);

        $secret = json_decode($response->getBody()->getContents(), true);
        return $secret['value'];
    }
}
