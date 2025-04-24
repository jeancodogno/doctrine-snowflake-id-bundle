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
use \Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\ORM\Mapping as ORM;
use JeanCodogno\DoctrineSnowflakeIdBundle\Attributes\SnowflakeColumn;

pest()->extend(Tests\TestCase::class)->in('Unit');
pest()->extend(KernelTestCase::class)->in('Integration');

#[ODM\Document]
class TestDocument {
    #[ODM\Field(type: 'bigint')]
    #[SnowflakeField]
    public ?string $publicId = null;
}

#[ODM\Document]
class TestDocumentWithIdField {
    #[ODM\Id(strategy: 'NONE', type: 'string')]
    #[SnowflakeField]
    public ?string $id = null;
}

#[ODM\Document]
class TestDocumentWithoutAttribute {
    #[ODM\Field(type: 'bigint')]
    public ?string $publicId = null;
}

#[ODM\Document]
class TestDocumentFilled {
    #[ODM\Field(type: 'bigint')]
    #[SnowflakeField]
    public ?string $publicId = '123456789012345678';
}

#[ORM\Entity]
class TestEntity {
    #[ORM\Id]
    #[SnowflakeColumn]
    public ?string $publicId = null;
}

#[ORM\Entity]
class TestEntityWithIDField {
    #[ORM\Column(type: 'bigint', unique: true)]
    #[SnowflakeColumn]
    public ?string $id = null;
}

#[ORM\Entity]
class TestEntityWithoutAttribute {
    #[ORM\Column(type: 'bigint')]
    public ?string $publicId = null;
}

#[ODM\Document]
class TestEntityFilled {
    #[ORM\Column(type: 'bigint')]
    #[SnowflakeColumn]
    public ?string $publicId = '123456789012345678';
}

afterEach(function () {
    \JeanCodogno\DoctrineSnowflakeIdBundle\IdGenerator\SnowflakeIdGenerator::addGenerator(null);
    \JeanCodogno\DoctrineSnowflakeIdBundle\IdGenerator\MongoSnowflakeIdGenerator::addGenerator(null);
});