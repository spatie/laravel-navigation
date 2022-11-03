<?php

use Spatie\Navigation\Helpers\ActiveUrlChecker;
use Spatie\Navigation\Navigation;
use Spatie\Navigation\Section;

beforeEach(function () {
    $this->navigation = new Navigation(new ActiveUrlChecker('/', '/'));
});

it('has a title')
    ->tap(fn () => $this->section = new Section($this->navigation, 'Hello, world!'))
    ->expect(fn () => $this->section->title)
    ->toEqual('Hello, world!');

it('has an url')
    ->tap(fn () => $this->section = new Section($this->navigation, 'Hello, world!', '/'))
    ->expect(fn () => $this->section->url)
    ->toEqual('/');

it('can have additional attributes')
    ->tap(
        fn () =>
        $this->section = (new Section($this->navigation, 'Hello, world!', '/'))
            ->attributes(['foo' => 'bar'])
    )
    ->expect(fn () => $this->section->attributes)->toHaveKey('foo')
    ->and(fn () => $this->section->attributes['foo'])->toEqual('bar');

it('can have children')
    ->tap(fn () => $this->section = (new Section($this->navigation, 'Hello, world!', '/'))->add('Blog', '/posts'))
    ->expect(fn () => $this->section->children)->toHaveCount(1)
    ->and(fn () => $this->section->children[0]->title)->toEqual('Blog')
    ->and(fn () => $this->section->children[0]->url)->toEqual('/posts');

it('can configure children')
    ->tap(
        fn () => $this->section = (new Section($this->navigation, 'Hello, world!', '/'))
            ->add('Blog', '/posts', fn (Section $section) => $section->attributes(['baz' => 'qux']))
    )
    ->expect(fn () => $this->section->children)->toHaveCount(1)
    ->and(fn () => $this->section->children[0]->attributes)->toHaveCount(1)
    ->and(fn () => $this->section->children[0]->attributes)->toHaveKey('baz')
    ->and(fn () => $this->section->children[0]->attributes['baz'])->toEqual('qux');

test('attributes can be configured inline')
    ->tap(
        fn () => $this->section = (new Section($this->navigation, 'Top level', '/'))
            ->add('First link', '/link', attributes: ['icon' => 'mdi:link'])
    )
    ->expect(fn () => $this->section->children)->toHaveCount(1)
    ->and(fn () => $this->section->children[0]->attributes)->toHaveKey('icon');

it('has depth')
    ->tap(
        fn () =>
        $this->section = (new Section($this->navigation, 'Hello, world!', '/'))->add('Blog', '/posts')
    )
    ->expect(fn () => $this->section->getDepth())->toEqual(0)
    ->and(fn () => $this->section->children[0]->getDepth())->toEqual(1);
