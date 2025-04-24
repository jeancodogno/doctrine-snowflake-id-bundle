<?php

declare(strict_types=1);

namespace JeanCodogno\DoctrineSnowflakeIdBundle\EventListener;

use Doctrine\Bundle\MongoDBBundle\Attribute\AsDocumentListener;
use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use Doctrine\ODM\MongoDB\Events;
use JeanCodogno\DoctrineSnowflakeIdBundle\Attributes\SnowflakeField;

#[AsDocumentListener(event: Events::prePersist)]
final class MongoSnowflakeListener extends BaseSnowflakeListener
{
    protected string $attribute = SnowflakeField::class;
    public function prePersist(LifecycleEventArgs $event): void
    {
        $document = $event->getDocument();

        $this->populateSnowflakeColumns($document);
    }
}
