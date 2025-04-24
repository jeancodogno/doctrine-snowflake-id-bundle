<?php

declare(strict_types=1);

namespace JeanCodogno\DoctrineSnowflakeIdBundle\IdGenerator;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Id\IdGenerator;
use JeanCodogno\DoctrineSnowflakeIdBundle\Services\SnowflakeGenerator;

class MongoSnowflakeIdGenerator implements IdGenerator
{
    private static ?SnowflakeGenerator $generator = null;

    public static function addGenerator(?SnowflakeGenerator $generator): void
    {
        self::$generator = $generator;
    }

    /**
     * generate
     *
     * @param $entity
     */
    public function generate(DocumentManager $dm, object $document): string
    {
        if (! self::$generator) {
            throw new \RuntimeException('SnowflakeGenerator has not been set.');
        }

        return self::$generator->generate();
    }
}
