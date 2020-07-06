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
        $activeSection = $this->navigation->activeSection();

        $this->assertNotNull($activeSection);
        $this->assertEquals('Topics', $activeSection->title);
    }

    public function test_it_returns_null_when_there_is_no_active_section()
    {
        $activeSection = (new Navigation($this->activeUrlChecker))->add('Home', '/')->activeSection();

        $this->assertNull($activeSection);
    }

    public function test_it_can_render_a_tree()
    {
        $this->assertMatchesJsonSnapshot($this->navigation->tree());
    }

    public function test_doesnt_render_hidden_items_in_a_tree()
    {
        $this->assertMatchesJsonSnapshot(
            $this->navigation
                ->add('Hidden', '/', fn (Section $section) => $section->hide())
                ->tree()
        );
    }

    public function test_it_can_render_breadcrumbs()
    {
        $this->assertMatchesJsonSnapshot($this->navigation->breadcrumbs());
    }
}
