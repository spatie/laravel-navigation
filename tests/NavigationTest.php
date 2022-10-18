<?php

namespace Spatie\Navigation\Test;

use PHPUnit\Framework\TestCase;
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
        $this->activeUrlChecker = new ActiveUrlChecker('/topics/laravel', '/');

        $this->navigation = (new Navigation($this->activeUrlChecker))
            ->add('Home', '/')
            ->add('Blog', '/posts', function (Section $section) {
                $section
                    ->add('All posts', '/posts')
                    ->add('Topics', '/topics');
            });
    }

    public function test_it_can_get_the_active_section()
    {
        $activeSection = $this->navigation->activeSection();

        $this->assertNotNull($activeSection);
        $this->assertEquals('Topics', $activeSection->title);
    }

    public function test_it_can_render_the_active_section()
    {
        $this->assertMatchesSnapshot($this->navigation->current());
    }

    public function test_it_returns_null_when_rendering_an_empty_section()
    {
        $navigation = (new Navigation($this->activeUrlChecker))->add('Home', '/');

        $this->assertNull($navigation->activeSection());
        $this->assertNull($navigation->current());
    }

    public function test_it_returns_null_when_there_is_no_active_section()
    {
        $activeSection = (new Navigation($this->activeUrlChecker))->add('Home', '/')->activeSection();

        $this->assertNull($activeSection);
    }

    public function test_it_can_render_a_tree()
    {
        $this->assertMatchesSnapshot($this->navigation->tree());
    }

    public function test_doesnt_render_hidden_items_in_a_tree()
    {
        $this->assertMatchesSnapshot(
            $this->navigation
                ->add('Hidden', '/', fn (Section $section) => $section->hide())
                ->tree()
        );
    }

    public function test_it_can_render_breadcrumbs()
    {
        $this->assertMatchesSnapshot($this->navigation->breadcrumbs());
    }

    public function test_item_added_with_true_condition()
    {
        $before = clone $this->navigation;
        $this->navigation->addIf(true, 'Team', '/team');
        $this->assertNotEquals($before, $this->navigation);
    }

    public function test_item_not_added_with_false_condition()
    {
        $before = clone $this->navigation;
        $this->navigation->addIf(false, 'Team', '/team');
        $this->assertEquals($before, $this->navigation);
    }

    public function test_section_added_with_true_condition()
    {
        $before = clone $this->navigation;
        $this->navigation->add('Team', '/team', fn (Section $section) =>
            $section->addIf(true, 'Switch', 'team/switch'));
        $this->assertNotEquals($before, $this->navigation);
    }
}
