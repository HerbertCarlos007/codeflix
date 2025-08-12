<?php

namespace Unit\Domain\Entity;

use Core\Domain\Entity\Category;
use Core\Domain\Exception\EntityValidationException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CategoryUnitTest extends TestCase
{
    public function testAttributes()
    {
        $category = new Category(
            name: 'New cat',
            description: 'New desc',
            isActive: true,
        );

        $this->assertNotEmpty($category->id());
        $this->assertEquals('New cat', $category->name);
        $this->assertEquals('New desc', $category->description);
        $this->assertTrue($category->isActive);
    }

    public function testActivated()
    {
        $category = new Category(
            name: 'New cat',
            isActive: false
        );

        $this->assertFalse($category->isActive);
        $category->activate();
        $this->assertTrue($category->isActive);
    }

    public function testDisabled()
    {
        $category = new Category(
            name: 'New cat'
        );

        $this->assertTrue($category->isActive);
        $category->disable();
        $this->assertFalse($category->isActive);
    }

    public function testeUpdate()
    {
        $uuid = (string) Uuid::uuid4()->toString();

        $category = new Category(
            id: $uuid,
            name: 'New cat',
            description: 'New desc',
            isActive: true,
        );

        $category->update(
            name: 'new_name',
            description: 'new desc',
        );

        $this->assertEquals($uuid, $category->id());
        $this->assertEquals('new_name', $category->name);
        $this->assertEquals('new desc', $category->description);
    }

    public function testExceptionName()
    {
        try {
            new Category(
                name: 'N',
                description: 'New desc',
            );

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

    public function testExceptionDescription()
    {
        try {
            new Category(
                name: 'Name Cat',
                description: random_bytes(999999),
            );

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }
}