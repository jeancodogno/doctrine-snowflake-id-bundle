<?php

declare(strict_types=1);

namespace JeanCodogno\DoctrineSnowflakeIdBundle;

use JeanCodogno\DoctrineSnowflakeIdBundle\EventListener\MongoSnowflakeListener;
use JeanCodogno\DoctrineSnowflakeIdBundle\EventListener\SnowflakeListener;
use JeanCodogno\DoctrineSnowflakeIdBundle\IdGenerator\MongoSnowflakeIdGenerator;
use JeanCodogno\DoctrineSnowflakeIdBundle\IdGenerator\SnowflakeIdGenerator;
use JeanCodogno\DoctrineSnowflakeIdBundle\Services\SnowflakeGenerator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class DoctrineSnowflakeIdBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->register(SnowflakeGenerator::class)
            ->setAutowired(true)
            ->setAutoconfigured(true)
            ->setPublic(true);

        $container->register(SnowflakeIdGenerator::class)
            ->setAutowired(true)
            ->setAutoconfigured(true)
            ->setPublic(true);

        $container->register(MongoSnowflakeIdGenerator::class)
            ->setAutowired(true)
            ->setAutoconfigured(true)
            ->setPublic(true);

        $container->register(SnowflakeListener::class)
            ->setAutowired(true)
            ->setAutoconfigured(true);

        $container->register(MongoSnowflakeListener::class)
            ->setAutowired(true)
            ->setAutoconfigured(true);
    }

    public function boot(): void
    {
        /**
         * @var ContainerBuilder $container
         * */
        $container = $this->container;

        /**
         * @var SnowflakeGenerator $generator
         * */
        $generator = $container->get(SnowflakeGenerator::class);
        SnowflakeIdGenerator::addGenerator($generator);
        MongoSnowflakeIdGenerator::addGenerator($generator);
    }
}
