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

use App\Common\Constants\BaseStatus;
use App\Common\Exceptions\BusinessException;
use App\Common\Util\Auth\Exception\InvalidTokenException;
use App\Common\Util\Auth\JwtSubject;
use App\Common\Util\Auth\Middleware\BaseAuthMiddleware;
use App\Constants\Errors\PlatformError;
use App\Infrastructure\PlatformInterface;
use Hyperf\Di\Annotation\Inject;
use Psr\Http\Message\ServerRequestInterface;

class AdminMiddleware extends BaseAuthMiddleware
{
    #[Inject()]
    protected PlatformInterface $platform;

    public static function getIss(): ?string
    {
        return 'admin';
    }

    protected function handlePayload(ServerRequestInterface $request, JwtSubject $payload): array
    {
        $platform = $this->platform->detail([
            'id' => $payload->data['sub'] ?? -1,
        ], ['id', 'role_id', 'status']);

        if (empty($platform)) {
            throw new InvalidTokenException();
        }

        // 状态
        if ($platform->status !== BaseStatus::NORMAL) {
            throw new BusinessException(PlatformError::FROZEN);
        }

        return $platform->toArray();
    }

    protected function getTestPayload(ServerRequestInterface $request): array
    {
        $payload = new JwtSubject();
        $payload->data['sub'] = 1;
        return $this->handlePayload($request, $payload);
    }
}
