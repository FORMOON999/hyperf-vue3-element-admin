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

namespace App\Common\Util\IPC;

use App\Common\Util\IPC\Config\ConfigIPC;
use App\Common\Util\IPC\Config\PipeConfig;
use App\Common\Util\IPC\Config\PipeConfigInterface;
use App\Common\Util\IPC\Helper\SysConfigHelper;
use App\Infrastructure\ConfigInterface;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Framework\Event\BootApplication;
use Hyperf\Framework\Event\OnPipeMessage;
use Hyperf\Process\Event\PipeMessage as UserProcessPipeMessage;
use Psr\Container\ContainerInterface;

// ipc config listener
#[Listener]
class IPCListener implements ListenerInterface
{
    public function __construct(protected ContainerInterface $container, protected ConfigIPC $ipc, protected ConfigInterface $config) {}

    public function listen(): array
    {
        return [
            BootApplication::class,
            OnPipeMessage::class,
            UserProcessPipeMessage::class,
        ];
    }

    public function process(object $event): void
    {
        if ($event instanceof BootApplication) {
            $result = $this->config->getList([], ['key', 'value']);
            $data = [];
            foreach ($result->list as $item) {
                $data[$item->key] = $item->value;
            }
            $this->ipc->update(new PipeConfig([SysConfigHelper::CONFIG_KEY => $data]));
        }

        if ($event instanceof OnPipeMessage || $event instanceof UserProcessPipeMessage) {
            $event->data instanceof PipeConfigInterface && $this->ipc->update($event->data);
        }
    }
}
