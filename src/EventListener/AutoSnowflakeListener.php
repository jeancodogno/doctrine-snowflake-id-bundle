<?php

declare(strict_types=1);

namespace JeanCodogno\DoctrineSnowflakeIdBundle\EventListener;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;
use JeanCodogno\DoctrineSnowflakeIdBundle\Attributes\AutoSnowflake;
use JeanCodogno\DoctrineSnowflakeIdBundle\Services\SnowflakeGenerator;

#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
final class AutoSnowflakeListener
{
    public function __construct(
        private SnowflakeGenerator $generator
    ) {
    }

    public function prePersist(PrePersistEventArgs $event): void
    {
        $entity = $event->getObject();
        $reflection = new \ReflectionClass($entity);

        foreach ($reflection->getProperties() as $property) {
            $attributes = $property->getAttributes(AutoSnowflake::class);
            if ($attributes !== []) {
                $property->setAccessible(true);
                if ($property->getValue($entity) === null) {
                    $id = $this->generator->generate();
                    $property->setValue($entity, $id);
                }
            }
        }
    }
}
