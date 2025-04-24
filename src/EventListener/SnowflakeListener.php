<?php

declare(strict_types=1);

namespace JeanCodogno\DoctrineSnowflakeIdBundle\EventListener;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;

#[AsDoctrineListener(event: Events::prePersist)]
final class SnowflakeListener extends BaseSnowflakeListener
{
    public function prePersist(PrePersistEventArgs $event): void
    {
        $entity = $event->getObject();
        $this->populateSnowflakeColumns($entity);
    }
}
