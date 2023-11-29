<?php

use GuzzleHttp\Client;
use Sabre\DAV\Client as WebDavClient;


include '../../../../vendor/autoload.php';



class HttpRequestHelper
{

    private const CLIENT_ID = 'xdXOt13JKxym1B1QcEncf2XDkLAexMBFwiT9j6EfhhHFJhs2KM9jbjTmf8JBXE69';
    private const CLIENT_SECRET = 'UBntmLjC2yYCeHwsyj73Uwo9TAaecAetRwMw0xYcvNL9yRdLSUi0hUAHfvCHFeFh';
    protected string $ocisUrl = "https://host.docker.internal:9200";
    private ?string $tokenUrl = null;
    private ?Client $guzzleClient = null;
    private ?Client $webDavClient = null;

    protected function getAccessToken(string $username = "admin", string $password = "admin"): string
    {
        $guzzleClient = $this->getGuzzleClient();
        $response = $guzzleClient->post((string)$this->tokenUrl, [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => self::CLIENT_ID,
                'client_secret' => self::CLIENT_SECRET,
                'username' => $username,
                'password' => $password,
                'scope' => 'openid profile email offline_access'
            ]
        ]);
        $accessTokenResponse = json_decode($response->getBody()->getContents(), true);
        if ($accessTokenResponse === null) {
            throw new \Exception('Could not decode token response');
        }
        // @phpstan-ignore-next-line
        return $accessTokenResponse['access_token'];
    }

    function createFile($fileName)
    {




        $webDavClient = $this->createWebDavClient();
        $webDavClient->sendRequest('MKCOL', rawurlencode(ltrim("/dav/files/admin/$fileName", "/")));
    }

    protected function getGuzzleClient(): Client
    {
        if ($this->guzzleClient !== null) {
            return $this->guzzleClient;
        }
        $guzzleClient = new Client([
            'base_uri' => $this->ocisUrl,
            'verify' => false
        ]);
        $this->guzzleClient = $guzzleClient;
        return $this->guzzleClient;
    }

    protected function getWebDavClient(): Client
    {
        if ($this->webDavClient !== null) {
            return $this->webDavClient;
        }
        $webDavClient = new Client([
            'base_uri' => $this->ocisUrl,
        ]);
        $webDavClient->setCustomSetting($this->token);
        $this->guzzleClient = $guzzleClient;
        return $this->guzzleClient;
    }
}
