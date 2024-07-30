<?php

namespace Hollow3464\HtmxMiddlewarePsr;

use Hollow3464\HtmxPsr\HtmxRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class HtmxMiddlewarePsr implements MiddlewareInterface
{
    public const ATTRIBUTE_NAME = 'HTMX_REQUEST_ATTRIBUTE';

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $htmx = HtmxRequest::fromRequest($request);

        return $handler->handle(
            $request->withAttribute(self::ATTRIBUTE_NAME, $htmx)
                ->withAttribute(self::class, $htmx)
        );
    }

    public static function getRequest(ServerRequestInterface $request): ?HtmxRequest
    {
        $out = $request->getAttribute(self::ATTRIBUTE_NAME) ?? $request->getAttribute(self::class);

        if (!$out) {
            return null;
        }

        if (!$out instanceof HtmxRequest) {
            return null;
        }

        return $out;
    }
}
