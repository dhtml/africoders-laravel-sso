<?php
namespace Africoders\SSO\Controllers;

use Flarum\Api\Controller\AbstractShowController;
use Flarum\Http\RequestUtil;
use Flarum\Tags\Api\Serializer\TagSerializer;
use Flarum\Tags\Tag;
use Flarum\User\User;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Arr;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;
use Illuminate\Encryption\Encrypter;

class DHTMLSSOController extends AbstractShowController
{
    /**
     * {@inheritdoc}
     */
    public $serializer = TagSerializer::class;

    /**
     * @var Dispatcher
     */
    protected $events;
    protected $session;

    public function __construct(Dispatcher $events)
    {
        $this->events = $events;
    }

    /**
     * {@inheritdoc}
     */
    protected function data(ServerRequestInterface $request, Document $document)
    {
        $cookies = $request->getCookieParams();
        $sessionCookie = $cookies["africoders_account_session"];

        $config = require __DIR__ . '/../../../../../config.php'; // Adjust the path as needed
        $sso = $config["sso"] ?? [];
        $encryptionKey = $sso['encryptionKey'];
        exit($encryptionKey);

        $encrypter = new Encrypter(base64_decode($encryptionKey), 'AES-256-CBC');

        var_dump($sessionCookie);
        exit();

        //var_dump($this->events);
        return "DHTML SSO";
    }
}
