<?php

use Spatie\Navigation\Helpers\ActiveUrlChecker;
use Spatie\Navigation\Navigation;
use Spatie\Navigation\Section;

beforeEach(function () {
    $this->navigation = new Navigation(new ActiveUrlChecker('/', '/'));
});

it('has a title', function () {
    $section = new Section($this->navigation, 'Hello, world!');

    expect($section)->toEqual('Hello, world!');
});

it('has an url', function () {
    $section = new Section($this->navigation, 'Hello, world!', '/');

    expect($section->url)->toEqual('/');
});

it('can have additional attributes', function () {
    $section = (new Section($this->navigation, 'Hello, world!', '/'))
        ->attributes(['foo' => 'bar']);

    expect($section->attributes)->toHaveKey('foo')
        ->and($section->attributes['foo'])->toEqual('bar');
});

it('can have children', function () {
    $section = (new Section($this->navigation, 'Hello, world!', '/'))->add('Blog', '/posts');

    expect($section->children)->toHaveCount(1)
        ->and($section->children[0]->title)->toEqual('Blog')
        ->and($section->children[0]->url)->toEqual('/posts');
});

it('can configure children', function () {
    $section = (new Section($this->navigation, 'Hello, world!', '/'))
        ->add('Blog', '/posts', fn (Section $section) => $section->attributes(['baz' => 'qux']));

    expect($section->children)->toHaveCount(1)
        ->and($section->children[0]->attributes)->toHaveCount(1)
        ->and($section->children[0]->attributes)->toHaveKey('baz')
        ->and($section->children[0]->attributes['baz'])->toEqual('qux');
});

test('attributes can be configured inline', function () {
    $section = (new Section($this->navigation, 'Top level', '/'))
        ->add('First link', '/link', attributes: ['icon' => 'mdi:link']);

    expect($section->children)->toHaveCount(1)
        ->and($section->children[0]->attributes)->toHaveKey('icon');
});

it('has depth', function () {
    $section = (new Section($this->navigation, 'Hello, world!', '/'))->add('Blog', '/posts');

    expect($section->getDepth())->toEqual(0)
        ->and($section->children[0]->getDepth())->toEqual(1);
});
