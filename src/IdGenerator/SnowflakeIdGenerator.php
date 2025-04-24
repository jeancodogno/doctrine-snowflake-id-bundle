<?php

declare(strict_types=1);

namespace JeanCodogno\DoctrineSnowflakeIdBundle\IdGenerator;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Id\AbstractIdGenerator;
use JeanCodogno\DoctrineSnowflakeIdBundle\Services\SnowflakeGenerator;

class SnowflakeIdGenerator extends AbstractIdGenerator
{
    private static ?SnowflakeGenerator $generator = null;

    public static function addGenerator(?SnowflakeGenerator $generator): void
    {
        self::$generator = $generator;
    }

    /**
     * generateId
     *
     * @param $entity
     */
    public function generateId(EntityManagerInterface $em, ?object $entity): string
    {
        if (! self::$generator) {
            throw new \RuntimeException('SnowflakeGenerator has not been set.');
        }

        return self::$generator->generate();
    }
}
