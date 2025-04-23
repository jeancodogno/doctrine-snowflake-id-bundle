<?php

declare(strict_types=1);

use JeanCodogno\DoctrineSnowflakeIdBundle\Services\SnowflakeGenerator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\DependencyInjection\Reference;

it('generates a valid snowflake ID', function () {

    $container = new ContainerBuilder();
    
    $container->setParameter('snowflake_id.start_timestamp', 1609459200000);
    $container->setParameter('snowflake_id.datacenter_id', 1);
    $container->setParameter('snowflake_id.worker_id', 1);
    
    $container->register(SnowflakeGenerator::class)
        ->setAutowired(true)
        ->setAutoconfigured(true)
        ->setPublic(true);

    $container->compile();

    /** @var SnowflakeGenerator $generator */
    $generator = $container->get(SnowflakeGenerator::class);

    $id = $generator->generate();

    expect($id)->toBeString()->and(strlen($id))->toBeGreaterThan(10);
});

it('generates a valid snowflake ID without parameters', function () {

    $container = new ContainerBuilder();
    $container->register(SnowflakeGenerator::class)
        ->setAutowired(true)
        ->setAutoconfigured(true)
        ->setPublic(true);

    $container->compile();

    /** @var SnowflakeGenerator $generator */
    $generator = $container->get(SnowflakeGenerator::class);

    $id = $generator->generate();

    expect($id)->toBeString()->and(strlen($id))->toBeGreaterThan(10);
});

it('throws an exception if start timestamp is invalid', function () {
    $container = new ContainerBuilder();

    $container->setParameter('snowflake_id.start_timestamp', 'invalid');

    $container->register(SnowflakeGenerator::class)
        ->setAutowired(true)
        ->setAutoconfigured(true)
        ->setPublic(true);

    $container->compile();

    expect(function() use ($container) {
        $container->get(SnowflakeGenerator::class);
    })->toThrow(\TypeError::class);
});

it('throws an exception if datacenter ID is invalid', function () {
    
    $container = new ContainerBuilder();

    $container->setParameter('snowflake_id.datacenter_id', 'invalid');

    $container->register(SnowflakeGenerator::class)
        ->setAutowired(true)
        ->setAutoconfigured(true)
        ->setPublic(true);

    $container->compile();

    expect(function() use ($container) {
        $container->get(SnowflakeGenerator::class);
    })->toThrow(\TypeError::class);
});

it('throws an exception if worker ID is invalid', function () {
    $container = new ContainerBuilder();

    $container->setParameter('snowflake_id.worker_id', 'invalid');

    $container->register(SnowflakeGenerator::class)
        ->setAutowired(true)
        ->setAutoconfigured(true)
        ->setPublic(true);

    $container->compile();

    expect(function() use ($container) {
        $container->get(SnowflakeGenerator::class);
    })->toThrow(\TypeError::class);
});
