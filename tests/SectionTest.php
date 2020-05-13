<?php

namespace Spatie\Navigation\Test;

use PHPUnit\Framework\TestCase;
use Spatie\Navigation\Section;

class SectionTest extends TestCase
{
    public function test_it_has_a_title()
    {
        $section = new Section('Hello, world!');

        $this->assertEquals('Hello, world!', $section->title);
    }

    public function test_it_has_a_url()
    {
        $section = new Section('Hello, world!', '/');

        $this->assertEquals('/', $section->url);
    }

    public function test_it_can_have_additional_attributes()
    {
        $section = (new Section('Hello, world!', '/'))->attributes(['foo' => 'bar']);

        $this->assertArrayHasKey('foo', $section->attributes);
        $this->assertEquals('bar', $section->attributes['foo']);
    }

    public function test_it_can_have_children()
    {
        $section = (new Section('Hello, world!', '/'))->add('Blog', '/posts');

        $this->assertCount(1, $section->children);
        $this->assertEquals('Blog', $section->children[0]->title);
        $this->assertEquals('/posts', $section->children[0]->url);
    }

    public function test_it_can_configure_children()
    {
        $section = (new Section('Hello, world!', '/'))
            ->add('Blog', '/posts', fn (Section $section) => $section->attributes(['baz' => 'qux']));

        $this->assertCount(1, $section->children);
        $this->assertCount(1, $section->children[0]->attributes);
        $this->assertArrayHasKey('baz', $section->children[0]->attributes);
        $this->assertEquals('qux', $section->children[0]->attributes['baz']);
    }
}
