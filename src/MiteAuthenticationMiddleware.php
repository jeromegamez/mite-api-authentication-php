<?php

declare(strict_types=1);

namespace Gamez\Mite;

use Psr\Http\Message\RequestInterface;

class MiteAuthenticationMiddleware
{
    /**
     * @var MiteRequestAuthenticator
     */
    private $authenticator;

    public function __construct(string $account, string $apiKey)
    {
        $this->authenticator = new MiteRequestAuthenticator($account, $apiKey);
    }

    public function __invoke(callable $handler)
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            return $handler($this->authenticator->authenticate($request), $options);
        };
    }
}
