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

namespace App\Common\Util\Auth;

use App\Common\Util\Auth\Exception\InvalidTokenException;
use HyperfExt\Jwt\Contracts\JwtFactoryInterface;
use HyperfExt\Jwt\Contracts\StorageInterface;
use HyperfExt\Jwt\Exceptions\TokenBlacklistedException;
use HyperfExt\Jwt\Exceptions\TokenExpiredException;
use HyperfExt\Jwt\Jwt;
use HyperfExt\Jwt\Manager;
use HyperfExt\Jwt\Storage\HyperfCache;
use HyperfExt\Jwt\Token;
use Throwable;

class JwtHelper
{
    /**
     * 提供了从请求解析 JWT 及对 JWT 进行一系列相关操作的能力。
     */
    protected Jwt $jwt;

    protected ?StorageInterface $storage = null;

    public function __construct(JwtFactoryInterface $jwtFactory)
    {
        $this->jwt = $jwtFactory->make();
    }

    public function make(array $data = []): string
    {
        $this->jwt->setCustomClaims([]);
        $subject = new JwtSubject();
        $subject->data = $data;
        return $this->jwt->fromSubject($subject);
    }

    public function logout(string $token, bool $forceForever = false): bool
    {
        return ! $this->jwt->setToken($this->handleToken($token))->invalidate($forceForever)->check();
    }

    public function refreshToken(string $token, bool $forceForever = false): string
    {
        try {
            $this->handleClaims($token, true);
            return $this->jwt->refresh($forceForever);
        } catch (Throwable $exception) {
            throw new InvalidTokenException();
        }
    }

    public function getManager(): Manager
    {
        return $this->jwt->getManager();
    }

    public function verifyToken(?string $token, bool $ignoreExpired = false): JwtSubject
    {
        $payload = new JwtSubject();
        if (empty($token)) {
            $payload->invalid = true;
            return $payload;
        }
        try {
            $payload->data = $this->handleClaims($token, $ignoreExpired);
        } catch (Throwable $e) {
            if ($e instanceof TokenExpiredException && $e->getMessage() === 'Token has expired') {
                $payload->expired = true;
            }
            if ($e instanceof TokenBlacklistedException && $e->getMessage() === 'The token has been blacklisted') {
                $payload->invalid = true;
            }
        }
        return $payload;
    }

    public function getTtl(): int
    {
        return $this->jwt->getPayloadFactory()->getTtl();
    }

    public function getStorage(): StorageInterface
    {
        if (is_null($this->storage)) {
            $storageClass = \Hyperf\Config\config('jwt.blacklist_storage', HyperfCache::class);
            $this->storage = \Hyperf\Support\make($storageClass, [
                'tag' => 'jwt.oss',
            ]);
        }
        return $this->storage;
    }

    protected function handleToken($token): Token
    {
        if (! $token instanceof Token) {
            $token = new Token($token);
        }
        return $token;
    }

    protected function handleClaims(string $token, bool $ignoreExpired = false): array
    {
        $data = $this->jwt->setToken($this->handleToken($token))->getPayload($ignoreExpired)->toArray();
        $defaultClaims = $this->jwt->getManager()->getPayloadFactory()->getDefaultClaims();
        foreach ($defaultClaims as $claim) {
            if ($claim === 'iss') {
                continue;
            }
            unset($data[$claim]);
        }
        $this->jwt->setCustomClaims($data);
        return $data;
    }
}
