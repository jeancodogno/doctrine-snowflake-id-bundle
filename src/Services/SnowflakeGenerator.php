<?php

declare(strict_types=1);

namespace JeanCodogno\DoctrineSnowflakeIdBundle\Services;

use Godruoyi\Snowflake\Snowflake;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SnowflakeGenerator
{
    private Snowflake $snowflake;

    public function __construct(
        ParameterBagInterface $params
    ) {
        $startTimestamp = $this->getParameter($params, 'start_timestamp');
        $datacenterId = (int) $this->getParameter($params, 'datacenter_id');
        $workerId = (int) $this->getParameter($params, 'worker_id');

        $this->snowflake = new Snowflake($datacenterId, $workerId);

        if ($startTimestamp !== null) {
            $this->snowflake->setStartTimeStamp($startTimestamp);
        }
    }

    public function getParameter(ParameterBagInterface $params, string $key): ?int
    {
        $workerId = $params->has('snowflake_id.'.$key)
        ? $params->get('snowflake_id.'.$key)
        : 0;

        return $this->ensureInt($key, $workerId);
    }

    public function generate(): string
    {
        return $this->snowflake->id();
    }

    private function ensureInt(string $key, mixed $value): int
    {
        if (! is_int($value)) {
            throw new \InvalidArgumentException(ucfirst($key) . ' must be an integer.');
        }

        return $value;
    }
}
