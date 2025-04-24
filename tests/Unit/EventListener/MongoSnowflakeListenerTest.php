<?php

declare(strict_types=1);

use JeanCodogno\DoctrineSnowflakeIdBundle\Services\SnowflakeGenerator;
use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use JeanCodogno\DoctrineSnowflakeIdBundle\Attributes\SnowflakeField;
use JeanCodogno\DoctrineSnowflakeIdBundle\EventListener\MongoSnowflakeListener;


it('assigns a Snowflake ID to fields marked with #[SnowflakeField]', function () {
    
    $document = new TestDocument();

    $expectedId = '123456789012345678';

    $generator = Mockery::mock(SnowflakeGenerator::class);
    
    /** @phpstan-ignore-next-line */
    $generator->shouldReceive('generate')
        ->once()
        ->andReturn($expectedId);

    $eventArgs = Mockery::mock(LifecycleEventArgs::class);

    /** @phpstan-ignore-next-line */
    $eventArgs->shouldReceive('getDocument')
        ->once()
        ->andReturn($document);

    /** @var SnowflakeGenerator $generator */
    $listener = new MongoSnowflakeListener($generator);
    
    /** @var LifecycleEventArgs $eventArgs  */
    $listener->prePersist($eventArgs);

    expect($document->publicId)->toBe($expectedId);
});

it('assigns a Snowflake ID to a ID annotation marked with #[SnowflakeField]', function () {
    
    $document = new TestDocumentWithIdField();

    $expectedId = '123456789012345678';

    $generator = Mockery::mock(SnowflakeGenerator::class);

    /** @phpstan-ignore-next-line */
    $generator->shouldReceive('generate')
        ->once()
        ->andReturn($expectedId);

    $eventArgs = Mockery::mock(LifecycleEventArgs::class);

    /** @phpstan-ignore-next-line */
    $eventArgs->shouldReceive('getDocument')
        ->once()
        ->andReturn($document);

    /** @var SnowflakeGenerator $generator */
    $listener = new MongoSnowflakeListener($generator);
    
    /** @var LifecycleEventArgs $eventArgs  */
    $listener->prePersist($eventArgs);

    expect($document->id)->toBe($expectedId);
});

it('not assigns a Snowflake ID to a field without #[SnowflakeField]', function () {

    $document = new TestDocumentWithoutAttribute();

    $unexpectedId = '123456789012345678';

    $generator = Mockery::mock(SnowflakeGenerator::class);

    /** @phpstan-ignore-next-line */
    $generator->shouldReceive('generate')
        ->never()
        ->andReturn($unexpectedId);

    $eventArgs = Mockery::mock(LifecycleEventArgs::class);

    /** @phpstan-ignore-next-line */
    $eventArgs->shouldReceive('getDocument')
        ->once()
        ->andReturn($document);

    /** @var SnowflakeGenerator $generator */
    $listener = new MongoSnowflakeListener($generator);
    
    /** @var LifecycleEventArgs $eventArgs  */
    $listener->prePersist($eventArgs);

    expect($document->publicId)->toBeNull();
});

it('not assigns a Snowflake ID to filled field', function () {
    
    $document = new TestDocumentFilled();

    $unexpectedId = '23456789012345678';
    $expectedId = $document->publicId;

    $generator = Mockery::mock(SnowflakeGenerator::class);

    /** @phpstan-ignore-next-line */
    $generator->shouldReceive('generate')
        ->never()
        ->andReturn($unexpectedId);

    $eventArgs = Mockery::mock(LifecycleEventArgs::class);

        /** @phpstan-ignore-next-line */
    $eventArgs->shouldReceive('getDocument')
        ->once()
        ->andReturn($document);

    /** @var SnowflakeGenerator $generator */
    $listener = new MongoSnowflakeListener($generator);
    
    /** @var LifecycleEventArgs $eventArgs  */
    $listener->prePersist($eventArgs);

    expect($document->publicId)->toBe($expectedId);
});