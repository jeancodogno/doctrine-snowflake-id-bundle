<?php

declare(strict_types=1);

namespace JeanCodogno\DoctrineSnowflakeIdBundle\EventListener;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use Doctrine\ODM\MongoDB\Events;
use JeanCodogno\DoctrineSnowflakeIdBundle\Attributes\SnowflakeColumn;
use JeanCodogno\DoctrineSnowflakeIdBundle\Services\SnowflakeGenerator;
use ReflectionClass;

#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
final class MongoSnowflakeListener
{
    public function __construct(
        private SnowflakeGenerator $generator
    ) {
    }

    public function prePersist(LifecycleEventArgs $event): void
    {
        $document = $event->getDocument();

        $refClass = new ReflectionClass($document);

        foreach ($refClass->getProperties() as $property) {
            $attributes = $property->getAttributes(SnowflakeColumn::class);
            if ($attributes !== []) {
                $property->setAccessible(true);
                if ($property->getValue($document) === null) {
                    $property->setValue($document, (string) $this->generator->generate());
                }
            }
        }
    }
}
