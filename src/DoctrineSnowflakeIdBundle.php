<?php

declare(strict_types=1);

namespace JeanCodogno\DoctrineSnowflakeIdBundle;

use JeanCodogno\DoctrineSnowflakeIdBundle\EventListener\MongoSnowflakeListener;
use JeanCodogno\DoctrineSnowflakeIdBundle\EventListener\SnowflakeListener;
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

        $container->register(SnowflakeListener::class)
            ->setAutowired(true)
            ->setAutoconfigured(true)
            ->addTag('doctrine.event_listener', ['event' => 'prePersist']);

        $container->register(MongoSnowflakeListener::class)
            ->setAutowired(true)
            ->setAutoconfigured(true)
            ->addTag('doctrine_mongodb.odm.event_listener', ['event' => 'prePersist']);
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
    }
}
