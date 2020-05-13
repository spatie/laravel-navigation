<?php

namespace Spatie\Navigation\Test;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Spatie\Navigation\Helpers\ActiveUrlChecker;
use Spatie\Navigation\Navigation;
use Spatie\Navigation\Section;
use Spatie\Snapshots\MatchesSnapshots;

class NavigationTest extends TestCase
{
    use MatchesSnapshots;

    private ActiveUrlChecker $activeUrlChecker;

    private Navigation $navigation;

    public function setUp(): void
    {
        $this->activeUrlChecker = new ActiveUrlChecker('/blog/topics/laravel', '/');

        $this->navigation = (new Navigation($this->activeUrlChecker))
            ->add('Home', '/')
            ->add('Blog', '/blog', function (Section $section) {
                $section
                    ->add('All posts', '/blog')
                    ->add('Topics', '/blog/topics');
            });
    }

    public function test_it_can_get_the_active_section()
    {
        $this->assertEquals('Topics', $this->navigation->activeSection()->title);
    }

    public function test_it_throws_a_runtime_exception_when_there_is_no_active_section()
    {
        $this->expectException(RuntimeException::class);

        (new Navigation($this->activeUrlChecker))->add('Home', '/')->activeSection();
    }

    public function test_it_can_render_a_tree()
    {
        $this->assertMatchesJsonSnapshot($this->navigation->tree());
    }

    public function test_it_can_render_breadcrumbs()
    {
        $this->assertMatchesJsonSnapshot($this->navigation->breadcrumbs());
    }
}
