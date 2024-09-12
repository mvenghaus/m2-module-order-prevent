<?php

declare(strict_types=1);

namespace Mvenghaus\OrderPrevent\Model;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;

class Logger extends \Monolog\Logger
{
    public function __construct()
    {
        parent::__construct('OrderPrevent', $this->initHandlers());
    }

    private function initHandlers(): array
    {
        return [
            (new StreamHandler(BP . '/var/log/order-prevent.log'))
                ->setFormatter(new LineFormatter("%datetime%: %message%\n", "Y-m-d H:i:s"))
        ];
    }
}