<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Common\Middleware;

use App\Common\Core\ServiceTrait;
use App\Common\Helpers\AseHelper;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EncryptMiddleware implements MiddlewareInterface
{
    use ServiceTrait;
    #[Inject]
    protected AseHelper $aseHelper;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        if (!str_starts_with($request->getUri()->getPath(), "/api") || \Hyperf\Support\env('APP_ENV') != 'prod') {
            return $response;
        }

        $result = json_decode($response->getBody()->getContents(), true);
        if (!empty($result['data'])) {
            $result['data'] = $this->aseHelper->encrypt($this->toJson($result['data']));
        }
        return $response->withBody(new SwooleStream($this->toJson($result)));
    }
}
