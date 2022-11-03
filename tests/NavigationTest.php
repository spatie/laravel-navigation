<?php

use Spatie\Navigation\Helpers\ActiveUrlChecker;
use Spatie\Navigation\Navigation;
use Spatie\Navigation\Section;

use function Spatie\Snapshots\assertMatchesSnapshot;

beforeEach(function () {
    $this->activeUrlChecker = new ActiveUrlChecker('/topics/laravel', '/');

    $this->navigation = (new Navigation($this->activeUrlChecker))
        ->add('Home', '/')
        ->add('Blog', '/posts', function (Section $section) {
            $section
                ->add('All posts', '/posts')
                ->add('Topics', '/topics');
        });
});

it('can get the active section', function () {
    $activeSection = $this->navigation->activeSection();

    expect($activeSection)
        ->not->toBeNull()
        ->title->toEqual('Topics');
});

it('can render the active section', function () {
    assertMatchesSnapshot($this->navigation->current());
});

it('returns `null` when rendering an empty section', function () {
    $navigation = (new Navigation($this->activeUrlChecker))->add('Home', '/');

    expect($navigation)
        ->activeSection()->toBeNull()
        ->current()->toBeNull();
});

it('returns `null` when there is no active section', function () {
    $activeSection = (new Navigation($this->activeUrlChecker))->add('Home', '/')->activeSection();

    expect($activeSection)->toBeNull();
});

it('can render a tree', function () {
    assertMatchesSnapshot($this->navigation->tree());
});

test("doesn't render hidden items in a tree", function () {
    assertMatchesSnapshot(
        $this->navigation
            ->add('Hidden', '/', fn (Section $section) => $section->hide())
            ->tree()
    );
});

it('can render breadcrumbs', function () {
    assertMatchesSnapshot($this->navigation->breadcrumbs());
});

test('item added with `true` condition', function () {
    $before = clone $this->navigation;
    $this->navigation->addIf(true, 'Team', '/team');

    expect($this->navigation)->not->toEqual($before);
});

test('item not added with `false` condition', function () {
    $before = clone $this->navigation;
    $this->navigation->addIf(false, 'Team', '/team');

    expect($this->navigation)->toEqual($before);
});

test('section added with `true` condition', function () {
    $before = clone $this->navigation;
    $this->navigation->add('Team', '/team', fn (Section $section) =>
    $section->addIf(true, 'Switch', 'team/switch'));

    expect($this->navigation)->not->toEqual($before);
});
