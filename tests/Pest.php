<?php

declare(strict_types=1);
/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

use JeanCodogno\DoctrineSnowflakeIdBundle\Attributes\SnowflakeField;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

pest()->extend(Tests\TestCase::class)->in('Unit');
pest()->extend(KernelTestCase::class)->in('Integration');

#[\Doctrine\ODM\MongoDB\Mapping\Annotations\Document]
class TestDocument {
    #[\Doctrine\ODM\MongoDB\Mapping\Annotations\Field(type: 'string')]
    #[SnowflakeField]
    public ?string $publicId = null;
}

#[\Doctrine\ODM\MongoDB\Mapping\Annotations\Document]
class TestDocumentWithIdField {
    #[\Doctrine\ODM\MongoDB\Mapping\Annotations\Id(strategy: 'NONE', type: 'string')]
    #[SnowflakeField]
    public ?string $id = null;
}

#[\Doctrine\ODM\MongoDB\Mapping\Annotations\Document]
class TestDocumentWithoutAttribute {
    #[\Doctrine\ODM\MongoDB\Mapping\Annotations\Field(type: 'string')]
    public ?string $publicId = null;
}

#[\Doctrine\ODM\MongoDB\Mapping\Annotations\Document]
class TestDocumentFilled {
    #[\Doctrine\ODM\MongoDB\Mapping\Annotations\Field(type: 'string')]
    #[SnowflakeField]
    public ?string $publicId = '123456789012345678';
}

afterEach(function () {
    \JeanCodogno\DoctrineSnowflakeIdBundle\IdGenerator\SnowflakeIdGenerator::addGenerator(null);
    \JeanCodogno\DoctrineSnowflakeIdBundle\IdGenerator\MongoSnowflakeIdGenerator::addGenerator(null);
});