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

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

pest()->extend(Tests\TestCase::class)->in('Unit');
pest()->extend(KernelTestCase::class)->in('Integration');


afterEach(function () {
    \JeanCodogno\DoctrineSnowflakeIdBundle\SnowflakeIdGenerator::addGenerator(null);
});