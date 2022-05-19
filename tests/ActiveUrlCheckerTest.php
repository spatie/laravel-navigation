<?php

namespace Spatie\Navigation\Tests;

use Orchestra\Testbench\TestCase;
use Spatie\Navigation\Helpers\ActiveUrlChecker;

class ActiveUrlCheckerTest extends TestCase
{
    /**
     * @test
     * @dataProvider urlsProvider
     */
    public function it_can_check_if_a_url_is_active(string $currentUrl, string $urlToCheck, bool $result)
    {
        $checker = new ActiveUrlChecker($urlToCheck, '/');

        $this->assertSame($result, $checker->check($currentUrl));
    }

    public function urlsProvider(): array
    {
        return [
            ['/', '/', true],
            ['https://example.com/', 'https://another-example.com/', false], // hosts don't match
            ['/foo', '/foo/bar', true],
            ['/bar', '/foo/bar', false],
            ['bar', 'bar', false], // Does not start with '/' which is the root path
        ];
    }
}
