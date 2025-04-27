<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\CategoryService;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryServiceTest extends TestCase
{
    use RefreshDatabase;

    private CategoryService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->service = $this->app->make(CategoryService::class);
    }

    #[Test]
    public function it_creates_a_new_category(): void
    {
        $data = ['name' => 'Новая категория'];

        $category = $this->service->create($data);

        $this->assertDatabaseHas('categories', [
            'id'   => $category->id,
            'name' => 'Новая категория',
        ]);
    }

    #[Test]
    public function it_lists_all_categories(): void
    {
        $names = ['A', 'B', 'C'];
        foreach ($names as $name) {
            $this->service->create(['name' => $name]);
        }

        $all = $this->service->list();
        $this->assertCount(3, $all);
        $this->assertEqualsCanonicalizing(
            $names,
            $all->pluck('name')->all()
        );
    }

    #[Test]
    public function it_gets_a_single_category_by_id(): void
    {
        $created = $this->service->create(['name' => 'SingleCat']);

        $fetched = $this->service->get($created->id);
        $this->assertEquals('SingleCat', $fetched->name);
    }

    #[Test]
    public function it_throws_when_getting_nonexistent_category(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->service->get(999);
    }

    #[Test]
    public function it_updates_category_name(): void
    {
        $category = $this->service->create(['name' => 'OldName']);

        $updated = $this->service->update($category->id, ['name' => 'NewName']);

        $this->assertEquals('NewName', $updated->name);
        $this->assertDatabaseHas('categories', [
            'id'   => $category->id,
            'name' => 'NewName',
        ]);
    }

    #[Test]
    public function it_deletes_a_category(): void
    {
        $category = $this->service->create(['name' => 'ToDelete']);

        $deleted = $this->service->delete($category->id);
        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    #[Test]
    public function it_returns_false_when_deleting_nonexistent_category(): void
    {
        $deleted = $this->service->delete(12345);
        $this->assertFalse($deleted);
    }
}
