<?php

declare(strict_types=1);

namespace JeanCodogno\DoctrineSnowflakeIdBundle\EventListener;

use JeanCodogno\DoctrineSnowflakeIdBundle\Attributes\SnowflakeColumn;
use JeanCodogno\DoctrineSnowflakeIdBundle\Services\SnowflakeGenerator;
use ReflectionClass;

abstract class BaseSnowflakeListener
{
    protected string $attribute = SnowflakeColumn::class;

    public function __construct(
        private SnowflakeGenerator $generator
    ) {
    }

    protected function populateSnowflakeColumns(object $entityOrDocument): void
    {
        $refClass = new ReflectionClass($entityOrDocument);
        $properties = $refClass->getProperties();
        
        foreach ($properties as $property) {
            $attributes = $property->getAttributes($this->attribute);
            if ($attributes !== []) {
                $property->setAccessible(true);
                if (! $property->isInitialized($entityOrDocument) || $property->getValue($entityOrDocument) === null) {
                    $id = $this->generator->generate();
                    $property->setValue($entityOrDocument, $id);
                }
            }
        }
    }
}
