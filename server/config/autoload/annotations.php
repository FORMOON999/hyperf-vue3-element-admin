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
use Hyperf\ApiDocs\Swagger\GenerateResponses;
use Hyperf\ApiDocs\Swagger\SwaggerComponents;
use Hyperf\DTO\Aspect\CoreMiddlewareAspect;
use Hyperf\DTO\JsonMapper;

/*
 * This file is part of Hyperf.
 *
 * @see     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
return [
    'scan' => [
        'paths' => [
            BASE_PATH . '/app',
        ],
        'ignore_annotations' => [
            'mixin',
        ],
        'class_map' => [
            // 字典
            JsonMapper::class => BASE_PATH . '/app/Common/Core/CLassMap/JsonMapper.php',
            CoreMiddlewareAspect::class => BASE_PATH . '/app/Common/Core/CLassMap/CoreMiddlewareAspect.php',
            GenerateResponses::class => BASE_PATH . '/app/Common/Core/CLassMap/GenerateResponses.php',
            SwaggerComponents::class => BASE_PATH . '/app/Common/Core/CLassMap/SwaggerComponents.php',
        ],
    ],
];
