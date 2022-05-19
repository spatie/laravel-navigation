<?php

namespace Spatie\Navigation\Tests;

use Orchestra\Testbench\TestCase;
use Spatie\Navigation\Helpers\Str;

class StrTest extends TestCase
{
    /** @test * */
    public function it_can_remove_from_start()
    {
        $this->assertSame('End', Str::removeFromStart('start', 'startEnd'));
        $this->assertSame('endEnd', Str::removeFromStart('start', 'endEnd'));
    }

    /** @test * */
    public function it_can_replace_first_occurence()
    {
        $this->assertSame('startEnd', Str::replaceFirst('start', '', 'startstartEnd'));
        $this->assertSame('endEnd', Str::replaceFirst('start', '', 'endEnd'));
    }

    /** @test * */
    public function it_can_ensure_left()
    {
        $this->assertSame('/url', Str::ensureLeft('/', 'url'));
        $this->assertSame('/url', Str::ensureLeft('/', '/url'));
    }

    /** @test * */
    public function it_can_ensure_right()
    {
        $this->assertSame('url/', Str::ensureRight('/', 'url'));
        $this->assertSame('url/', Str::ensureRight('/', 'url/'));
    }
}
