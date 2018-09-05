<?php

declare(strict_types=1);

namespace Gamez\Mite;

use Psr\Http\Message\RequestInterface;

class MiteRequestAuthenticator
{
    const HEADER = 'X-MiteApiKey';
    const BASE_HOST = '.mite.yo.lk';

    /**
     * @var string
     */
    private $account;

    /**
     * @var string
     */
    private $apiKey;

    public function __construct(string $account, string $apiKey)
    {
        $this->account = $account;
        $this->apiKey = $apiKey;
    }

    public function authenticate(RequestInterface $request): RequestInterface
    {
        if ($request->getUri()->getHost() === $this->account.self::BASE_HOST) {
            $request = $request->withHeader(self::HEADER, $this->apiKey);
        }

        return $request;
    }
}
