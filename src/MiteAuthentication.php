<?php

declare(strict_types=1);

namespace Gamez\Mite;

use Http\Message\Authentication;
use Psr\Http\Message\RequestInterface;

class MiteAuthentication implements Authentication
{
    /**
     * @var MiteRequestAuthenticator
     */
    private $authenticator;

    public function __construct(string $account, string $apiKey)
    {
        $this->authenticator = new MiteRequestAuthenticator($account, $apiKey);
    }

    public function authenticate(RequestInterface $request)
    {
        return $this->authenticator->authenticate($request);
    }
}
