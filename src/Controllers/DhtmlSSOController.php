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

use Africoders\SSO\Services\SessionService;

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
        $sessionService = new SessionService();
        $user = $sessionService->getUserFromRequest($request);

        /*
        $sso = $config["sso"] ?? [];
        $encryptionKey = $sso['encryptionKey'];

        $encrypter = new Encrypter(base64_decode($encryptionKey), 'AES-256-CBC');
        $sessionDecrypt = $encrypter->decrypt($sessionCookie,false);

        var_dump($sessionDecrypt);
        */
        exit();

        //var_dump($this->events);
        return "DHTML SSO";
    }
}
