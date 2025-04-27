<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;
use App\Services\ProductService;

class ProductServiceTest extends TestCase
{
    use RefreshDatabase;

    private ProductService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->service = $this->app->make(ProductService::class);
    }

    #[Test]
    public function it_lists_all_products()
    {
        $category = Category::factory()->create();
        // create 3 products
        for ($i = 1; $i <= 3; $i++) {
            $this->service->create([
                'name' => "P{$i}",
                'price' => $i * 10,
                'barcode' => (string)str_pad($i, 13, '0', STR_PAD_LEFT),
                'category_id' => $category->id,
            ]);
        }

        $all = $this->service->list();
        $this->assertCount(3, $all);
        $this->assertEqualsCanonicalizing(
            ['P1', 'P2', 'P3'],
            $all->pluck('name')->all()
        );
    }

    #[Test]
    public function it_gets_a_single_product_by_id()
    {
        $category = Category::factory()->create();
        $created = $this->service->create([
            'name' => 'Single',
            'price' => 20.00,
            'barcode' => '0000000000001',
            'category_id' => $category->id,
        ]);

        $fetched = $this->service->get($created->id);
        $this->assertEquals('Single', $fetched->name);
        $this->assertEquals(20.00, $fetched->price);
    }

    #[Test]
    public function it_throws_when_getting_nonexistent_product()
    {
        $this->expectException(ModelNotFoundException::class);
        $this->service->get(999);
    }

    #[Test]
    public function it_creates_a_new_product()
    {
        $category = Category::factory()->create();

        $data = [
            'name' => 'Test Product',
            'price' => 9.99,
            'barcode' => '1234567890123',
            'category_id' => $category->id,
        ];

        $product = $this->service->create($data);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Test Product',
            'price' => 9.99,
            'barcode' => '1234567890123',
            'category_id' => $category->id,
        ]);
    }

    #[Test]
    public function it_updates_price_of_existing_product()
    {
        $category = Category::factory()->create();
        $product = $this->service->create([
            'name' => 'Initial Product',
            'price' => 5.00,
            'barcode' => '9876543210987',
            'category_id' => $category->id,
        ]);

        $updated = $this->service->update($product->id, ['price' => 15.00]);

        $this->assertEquals(15.00, $updated->price);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'price' => 15.00,
        ]);
    }

    #[Test]
    public function it_deletes_a_product()
    {
        $category = Category::factory()->create();
        $product = $this->service->create([
            'name' => 'ToDelete',
            'price' => 50.00,
            'barcode' => '0000000000002',
            'category_id' => $category->id,
        ]);

        $deleted = $this->service->delete($product->id);
        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    #[Test]
    public function it_returns_false_when_deleting_nonexistent_product()
    {
        $deleted = $this->service->delete(12345);
        $this->assertFalse($deleted);
    }
}
