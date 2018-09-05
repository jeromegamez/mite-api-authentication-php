<?php

declare(strict_types=1);

namespace Gamez\Mite\Tests;

use Gamez\Mite\MiteRequestAuthenticator;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

class MiteRequestAuthenticatorTest extends TestCase
{
    /**
     * @var MiteRequestAuthenticator
     */
    private $authenticator;

    /**
     * @var string
     */
    private $account;

    /**
     * @var string
     */
    private $apiKey;

    protected function setUp()
    {
        $this->account = 'myaccount';
        $this->apiKey = 'myapikey';

        $this->authenticator = new MiteRequestAuthenticator($this->account, $this->apiKey);
    }

    /**
     * @test
     */
    public function it_sets_the_header()
    {
        $request = $this->prophesizeApiRequest($this->account, $this->apiKey);
        $request->withHeader(MiteRequestAuthenticator::HEADER, $this->apiKey)->shouldBeCalled();

        $this->authenticator->authenticate($request->reveal());
    }

    /**
     * @test
     */
    public function it_does_not_set_the_header()
    {
        $request = $this->prophesizeApiRequest('foo', 'bar');
        $request->withHeader()->shouldNotBeCalled();

        $this->authenticator->authenticate($request->reveal());
    }

    private function prophesizeApiRequest(string $account, string $apiKey)
    {
        $request = $this->prophesize(RequestInterface::class);
        $request->getUri()->willReturn($this->prophesizeApiUri($account));
        $request
            ->withHeader(MiteRequestAuthenticator::HEADER, $apiKey)
            ->willReturn($this->prophesizeAuthenticatedRequest($account, $apiKey));


        return $request;
    }

    private function prophesizeAuthenticatedRequest(string $account, string $apiKey)
    {
        $request = $this->prophesize(RequestInterface::class);
        $request->getUri()->willReturn($this->prophesizeApiUri($account));
        $request->getHeader(MiteRequestAuthenticator::HEADER)->willReturn([$apiKey]);
        $request->getHeaderLine(MiteRequestAuthenticator::HEADER)->willReturn($apiKey);

        return $request;
    }

    private function prophesizeApiUri(string $account)
    {
        $uri = $this->prophesize(UriInterface::class);
        $uri->getHost()->willReturn($account.MiteRequestAuthenticator::BASE_HOST);

        return $uri;
    }
}
