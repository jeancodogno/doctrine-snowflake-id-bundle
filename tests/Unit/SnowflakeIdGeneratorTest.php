<?php

declare(strict_types=1);

use JeanCodogno\DoctrineSnowflakeIdBundle\Services\SnowflakeGenerator;
use JeanCodogno\DoctrineSnowflakeIdBundle\SnowflakeIdGenerator;
use Doctrine\ORM\EntityManagerInterface;

it('generates a snowflake ID after setting the generator', function () {
    
    $mockGenerator = Mockery::mock(SnowflakeGenerator::class);
    
    /** @phpstan-ignore-next-line */
    $mockGenerator->shouldReceive('generate')->once()->andReturn('1234567890');

    /** @var SnowflakeGenerator $mockGenerator */
    SnowflakeIdGenerator::addGenerator($mockGenerator);

    $generator = new SnowflakeIdGenerator();

    $em = Mockery::mock(EntityManagerInterface::class);

    /** @var EntityManagerInterface $em */
    $id = $generator->generateId($em, null);

    expect($id)->toBe('1234567890');
});

it('throws an exception if generator is not set', function () {

    SnowflakeIdGenerator::addGenerator(null);
    
    $generator = new SnowflakeIdGenerator();
    $em = Mockery::mock(EntityManagerInterface::class);

    expect(function()  use ($generator, $em) {
        /** @var EntityManagerInterface $em */
        $generator->generateId($em, null);
    })->toThrow(RuntimeException::class, 'SnowflakeGenerator has not been set.');
    
});