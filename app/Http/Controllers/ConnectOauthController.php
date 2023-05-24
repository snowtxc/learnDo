<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Client;
use Google\Service\Calendar;
use Google\Service\Plus;
use Google_Client;

class ConnectOauthController extends Controller
{
    //

    public function connectOauthController()
    {
        $path = '/app/google-calendar/oauth-credentials.json';
        // $credentialsInfo = json_encode(json_decode(file_get_contents(storage_path() . $path), true));

        $client = new Client();
        // $client->setAuthConfig(storage_path() . $path);
        $pathToTokenStored = storage_path() . '/app/google-calendar/oauth-token.json';
        $oauthToken = json_decode(file_get_contents($pathToTokenStored), true);

        $credentialsPath = storage_path() . $path;
        putenv("GOOGLE_APPLICATION_CREDENTIALS=$credentialsPath");


        if ($client->isAccessTokenExpired()) {
            $client->setApplicationName('Learn Do');
            $client->setAuthConfig($credentialsPath);
            $client->fetchAccessTokenWithRefreshToken($oauthToken['refresh_token']);

            $token = $client->getAccessToken();
            file_put_contents($pathToTokenStored, json_encode($token));
        }
    }
}