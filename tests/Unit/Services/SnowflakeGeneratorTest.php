<?php

declare(strict_types=1);

use JeanCodogno\DoctrineSnowflakeIdBundle\Services\SnowflakeGenerator;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

it('generates a valid snowflake ID', function () {

    $params = Mockery::mock(ParameterBagInterface::class);
    
    /** @phpstan-ignore-next-line */
    $params->shouldReceive('has')
        ->with('snowflake_id.start_timestamp')
        ->andReturn(false);

    /** @phpstan-ignore-next-line */
    $params->shouldReceive('get')
        ->with('snowflake_id.start_timestamp')
        ->andReturn(1609459200000);

    /** @phpstan-ignore-next-line */
    $params->shouldReceive('has')
        ->with('snowflake_id.datacenter_id')
        ->andReturn(true);

    /** @phpstan-ignore-next-line */
    $params->shouldReceive('get')
        ->with('snowflake_id.datacenter_id')
        ->andReturn(1);

    /** @phpstan-ignore-next-line */
    $params->shouldReceive('has')
        ->with('snowflake_id.worker_id')
        ->andReturn(true);
    
    /** @phpstan-ignore-next-line */
    $params->shouldReceive('get')
        ->with('snowflake_id.worker_id')
        ->andReturn(1);

    /** @var ParameterBagInterface $params */
    $generator = new SnowflakeGenerator($params);

    $id = $generator->generate();

    expect($id)->toBeString()->and(strlen($id))->toBeGreaterThan(10);
});

it('generates a valid snowflake ID without parameters', function () {

    $params = Mockery::mock(ParameterBagInterface::class);

    /** @phpstan-ignore-next-line */
    $params->shouldReceive('has')
        ->with('snowflake_id.start_timestamp')
        ->andReturn(false);

    /** @phpstan-ignore-next-line */
    $params->shouldReceive('has')
        ->with('snowflake_id.datacenter_id')
        ->andReturn(false);

    /** @phpstan-ignore-next-line */
    $params->shouldReceive('has')
        ->with('snowflake_id.worker_id')
        ->andReturn(false);

    /** @var ParameterBagInterface $params */
    $generator = new SnowflakeGenerator($params);

    $id = $generator->generate();

    expect($id)->toBeString()->and(strlen($id))->toBeGreaterThan(10);
});

it('throws an exception if start timestamp is invalid', function () {
    $params = Mockery::mock(ParameterBagInterface::class);

    /** @phpstan-ignore-next-line */
    $params->shouldReceive('has')
        ->with('snowflake_id.start_timestamp')
        ->andReturn(true);

    /** @phpstan-ignore-next-line */
    $params->shouldReceive('get')
        ->with('snowflake_id.start_timestamp')
        ->andReturn('invalid');

    /** @phpstan-ignore-next-line */
    $params->shouldReceive('has')
        ->with('snowflake_id.datacenter_id')
        ->andReturn(false);

    /** @phpstan-ignore-next-line */
    $params->shouldReceive('has')
        ->with('snowflake_id.worker_id')
        ->andReturn(false);

        
    expect(function() use ($params) {
        /** @var ParameterBagInterface $params */
        new SnowflakeGenerator($params);
    })->toThrow(\InvalidArgumentException::class, 'Start_timestamp must be an integer.');
});

it('throws an exception if datacenter ID is invalid', function () {
    $params = Mockery::mock(ParameterBagInterface::class);

    /** @phpstan-ignore-next-line */
    $params->shouldReceive('has')
        ->with('snowflake_id.start_timestamp')
        ->andReturn(false);

    /** @phpstan-ignore-next-line */
    $params->shouldReceive('has')
        ->with('snowflake_id.datacenter_id')
        ->andReturn(true);

    /** @phpstan-ignore-next-line */
    $params->shouldReceive('get')
        ->with('snowflake_id.datacenter_id')
        ->andReturn('invalid');

    /** @phpstan-ignore-next-line */
    $params->shouldReceive('has')
        ->with('snowflake_id.worker_id')
        ->andReturn(false);

    expect(function() use ($params) {
        /** @var ParameterBagInterface $params */
        new SnowflakeGenerator($params);
    })->toThrow(\InvalidArgumentException::class, 'Datacenter_id must be an integer.');
});

it('throws an exception if worker ID is invalid', function () {
    $params = Mockery::mock(ParameterBagInterface::class);

    /** @phpstan-ignore-next-line */
    $params->shouldReceive('has')
        ->with('snowflake_id.start_timestamp')
        ->andReturn(false);

    /** @phpstan-ignore-next-line */
    $params->shouldReceive('has')
        ->with('snowflake_id.datacenter_id')
        ->andReturn(false);

    /** @phpstan-ignore-next-line */
    $params->shouldReceive('has')
        ->with('snowflake_id.worker_id')
        ->andReturn(true);

    /** @phpstan-ignore-next-line */
    $params->shouldReceive('get')
        ->with('snowflake_id.worker_id')
        ->andReturn('invalid');

    expect(function() use ($params) {
        /** @var ParameterBagInterface $params */
        new SnowflakeGenerator($params);
    })->toThrow(\InvalidArgumentException::class, 'Worker_id must be an integer.');
});
