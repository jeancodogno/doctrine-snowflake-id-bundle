<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManagerInterface;
use JeanCodogno\DoctrineSnowflakeIdBundle\Services\SnowflakeGenerator;
use Doctrine\ORM\Event\PrePersistEventArgs;
use JeanCodogno\DoctrineSnowflakeIdBundle\EventListener\SnowflakeListener;


it('assigns a Snowflake ID to fields marked with #[SnowflakeColumn]', function () {
    
    $entity = new TestEntity();

    $expectedId = '123456789012345678';

    $generator = Mockery::mock(SnowflakeGenerator::class);
    
    /** @phpstan-ignore-next-line */
    $generator->shouldReceive('generate')
        ->once()
        ->andReturn($expectedId);

    /** @var EntityManagerInterface $emi */
    $emi = Mockery::mock(EntityManagerInterface::class);
    $eventArgs = new PrePersistEventArgs($entity, $emi);

    /** @var SnowflakeGenerator $generator */
    $listener = new SnowflakeListener($generator);
    
    /** @var PrePersistEventArgs $eventArgs  */
    $listener->prePersist($eventArgs);

    expect($entity->publicId)->toBe($expectedId);
});

it('assigns a Snowflake ID to a ID annotation marked with #[SnowflakeColumn]', function () {
    
    $entity = new TestEntityWithIDField();

    $expectedId = '123456789012345678';

    $generator = Mockery::mock(SnowflakeGenerator::class);

    /** @phpstan-ignore-next-line */
    $generator->shouldReceive('generate')
        ->once()
        ->andReturn($expectedId);

    /** @var EntityManagerInterface $emi */
    $emi = Mockery::mock(EntityManagerInterface::class);
    $eventArgs = new PrePersistEventArgs($entity, $emi);

    /** @var SnowflakeGenerator $generator */
    $listener = new SnowflakeListener($generator);
    
    /** @var PrePersistEventArgs $eventArgs  */
    $listener->prePersist($eventArgs);

    expect($entity->id)->toBe($expectedId);
});

it('not assigns a Snowflake ID to a field without #[SnowflakeColumn]', function () {

    $entity = new TestEntityWithoutAttribute();

    $unexpectedId = '123456789012345678';

    $generator = Mockery::mock(SnowflakeGenerator::class);

    /** @phpstan-ignore-next-line */
    $generator->shouldReceive('generate')
        ->never()
        ->andReturn($unexpectedId);

    /** @var EntityManagerInterface $emi */
    $emi = Mockery::mock(EntityManagerInterface::class);
    $eventArgs = new PrePersistEventArgs($entity, $emi);

    /** @var SnowflakeGenerator $generator */
    $listener = new SnowflakeListener($generator);
    
    /** @var PrePersistEventArgs $eventArgs  */
    $listener->prePersist($eventArgs);

    expect($entity->publicId)->toBeNull();
});

it('not assigns a Snowflake ID to filled field', function () {
    
    $entity = new TestDocumentFilled();

    $unexpectedId = '23456789012345678';
    $expectedId = $entity->publicId;

    $generator = Mockery::mock(SnowflakeGenerator::class);

    /** @phpstan-ignore-next-line */
    $generator->shouldReceive('generate')
        ->never()
        ->andReturn($unexpectedId);

    /** @var EntityManagerInterface $emi */
    $emi = Mockery::mock(EntityManagerInterface::class);
    $eventArgs = new PrePersistEventArgs($entity, $emi);

    /** @var SnowflakeGenerator $generator */
    $listener = new SnowflakeListener($generator);
    
    /** @var PrePersistEventArgs $eventArgs  */
    $listener->prePersist($eventArgs);

    expect($entity->publicId)->toBe($expectedId);
});