<?php
namespace Africoders\SSO\Services;

use Http\Client\Exception;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Encryption\Encrypter;
use Africoders\SSO\Models\SessionModel;


$config = require __DIR__ . '/../../../../../config.php'; // Adjust the path as needed

class SessionService {
    public function getUserFromRequest(ServerRequestInterface $request) {
        $cookies = $request->getCookieParams();
        $sessionCookieName = ConfigService::getConfig("cookieName");
        $sessionCookie = $cookies[$sessionCookieName];

        $sessionId = $this->decryptSession($sessionCookie);
        if($sessionId) {
            $user = $this->getSessionUser($sessionId);
        }

        //var_dump($sessionId);
    }

    public function decryptSession($sessionCookie) {
        try {
            $encryptionKey = ConfigService::getConfig('encryptionKey');
            $cipher = ConfigService::getConfig('cipher');

            $encrypter = new Encrypter(base64_decode($encryptionKey), $cipher);
            $sessionDecrypt = $encrypter->decrypt($sessionCookie, false);
            $tokens = explode("|", $sessionDecrypt);
            return isset($tokens[1]) ? $tokens[1] : null;
        } catch(Exception $e) {
            return null;
        }
    }

    public function getSessionUser($sessionId) {
        $session = SessionModel::query()->where('id', $sessionId)->first();
        var_dump($session->user_id);
        /*
        $sessionTable = ConfigService::getConfig("laravel_session_table");
        $results = DB::select("SELECT user_id FROM sessions WHERE id = :sessionId", ['sessionId' => $sessionId]);
        var_dump($results);
        */
    }
}