<?php

declare(strict_types=1);

namespace JeanCodogno\DoctrineSnowflakeIdBundle\Services;

use Godruoyi\Snowflake\Snowflake;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class SnowflakeGenerator
{
    private Snowflake $snowflake;

    public function __construct(
        #[Autowire(param: 'snowflake_id.start_timestamp')]
        ?int $startTimestamp = null,
        #[Autowire(param: 'snowflake_id.datacenter_id')]
        int $datacenterId = 0,
        #[Autowire(param: 'snowflake_id.worker_id')]
        int $workerId = 0,
    ) {
        $this->snowflake = new Snowflake($datacenterId, $workerId);

        if ($startTimestamp !== null) {
            $this->snowflake->setStartTimeStamp($startTimestamp);
        }
    }

    public function generate(): string
    {
        return $this->snowflake->id();
    }
}
