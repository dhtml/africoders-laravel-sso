<?php

namespace Africoders\SSO\Services;

use Africoders\SSO\Models\LaravelSession;
use Africoders\SSO\Models\PivotUser;
use Flarum\Foundation\DispatchEventsTrait;
use Flarum\Http\RememberAccessToken;
use Flarum\Http\SessionAccessToken;
use Flarum\Http\SessionAuthenticator;
use Flarum\User\User;
use Flarum\User\UserRepository;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Encryption\Encrypter;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;


$config = require __DIR__ . '/../../../../../config.php'; // Adjust the path as needed

class SessionService
{
    use DispatchEventsTrait;

    protected $app;
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function getUserState(ServerRequestInterface $request)
    {
        $cookies = $request->getCookieParams();
        $sessionCookieName = ConfigService::getConfig("cookieName");
        $sessionCookie = $cookies[$sessionCookieName] ?? null;

        if(!$sessionCookie) {
            return null;
        }

        $session = $request->getAttribute('session');

        /**
         * @var User $actor
         */
        $actor = $request->getAttribute('actor');

        $sessionId = $this->decryptSession($sessionCookie);

        $userEmail = "";
        $flarumEmail = !$actor->isGuest() ? $actor->email : "";
        $isUserLoggedin = false;
        $isFlarumLoggedin = !$actor->isGuest();

        if ($sessionId) {
            //get email if the user is logged in on SSO
            $userEmail = $this->getSessionUserMail($sessionId);
            if ($userEmail) {
                $isUserLoggedin = true;
            }
        }

        $action = "";

        if($isUserLoggedin==$isUserLoggedin && $userEmail==$flarumEmail) {
            $action = "";
        } elseif ($isUserLoggedin) {
            $action = "login";
        } else {
            $action = "logout";
        }

        $data = [
            "isUserLoggedin" => $isUserLoggedin,
            "isFlarumLoggedin" => $isFlarumLoggedin,
            "userEmail" => $userEmail,
            "flarumEmail" => $flarumEmail,
            "action" => $action,
        ];

        return $data;
    }

    public function logoutUser($session)
    {
        resolve(SessionAuthenticator::class)->logOut($session);
    }

    public function decryptSession($sessionCookie)
    {
        try {
            $encryptionKey = ConfigService::getConfig('encryptionKey');
            $cipher = ConfigService::getConfig('cipher');

            $encrypter = new Encrypter(base64_decode($encryptionKey), $cipher);
            $sessionDecrypt = $encrypter->decrypt($sessionCookie, false);
            $tokens = explode("|", $sessionDecrypt);
            return isset($tokens[1]) ? $tokens[1] : null;
        } catch (\Exception $e) {
            return null;
        } catch (\RuntimeException $e) {
            return null;
        } catch (DecryptException $e) {
            return null;
        }
    }

    public function getSessionUserMail($sessionId)
    {
        $laravelSession = LaravelSession::query()->where('id', $sessionId)->first();
        if (!$laravelSession) {
            return null;
        }
        $laravelUserId = $laravelSession->user_id;

        $pivotUser = PivotUser::query()->where('laravel_user_id', $laravelUserId)->first();
        if (!$pivotUser) {
            return null;
        }

        $email = $pivotUser->email;
        return $email;
    }

    public function authenticateById($userId, $session)
    {
        try {
        $user = $this->users->findOrFail($userId);
        $token = $this->getToken($user);
        $access_token = SessionAccessToken::findValid($token);
        resolve(SessionAuthenticator::class)->logIn($session, $access_token);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function authenticateByEmail($email, $session)
    {
        $user = User::where("email",$email)->first();
        if(!$user) {return false;}
        return $this->authenticateById($user->id,$session);
    }


    private function getToken(User $user, bool $remember = false): string
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $token = $remember ? RememberAccessToken::generate($user->id) : SessionAccessToken::generate($user->id);
        $token->save();

        return $token->token;
    }
}