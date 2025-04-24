<?php

declare(strict_types=1);

use Doctrine\ODM\MongoDB\DocumentManager;
use JeanCodogno\DoctrineSnowflakeIdBundle\Services\SnowflakeGenerator;
use JeanCodogno\DoctrineSnowflakeIdBundle\IdGenerator\MongoSnowflakeIdGenerator;

it('generates a snowflake ID after setting the generator', function () {

    $document = new TestDocument();

    $mockGenerator = Mockery::mock(SnowflakeGenerator::class);
    
    /** @phpstan-ignore-next-line */
    $mockGenerator->shouldReceive('generate')->once()->andReturn('1234567890');

    /** @var SnowflakeGenerator $mockGenerator */
    MongoSnowflakeIdGenerator::addGenerator($mockGenerator);

    $generator = new MongoSnowflakeIdGenerator();

    $dm = Mockery::mock(DocumentManager::class);

    /** @var DocumentManager $dm */
    $id = $generator->generate($dm, $document);

    expect($id)->toBe('1234567890');
});

it('throws an exception if generator is not set', function () {

    MongoSnowflakeIdGenerator::addGenerator(null);
    
    $document = new TestDocument();

    $generator = new MongoSnowflakeIdGenerator();
    $dm = Mockery::mock(DocumentManager::class);

    expect(function()  use ($generator, $dm, $document) {
        /** @var DocumentManager $dm */
        $generator->generate($dm, $document);
    })->toThrow(RuntimeException::class, 'SnowflakeGenerator has not been set.');
    
});