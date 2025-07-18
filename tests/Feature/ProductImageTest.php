<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tests\TestCase;

class ProductImageTest extends TestCase
{
    public function test_vendor_can_upload_product_image(): void
    {
          Storage::fake('public');

    $vendor = User::factory()->create();
    $product = Product::factory()->for($vendor, 'vendor')->create();

    $res = $this->actingAs($vendor)->postJson("/api/products/{$product->id}/image", [
        'image' => UploadedFile::fake()->image('test.jpg', 600, 600)->size(200),
    ]);

    $res->assertOk()->assertJson(['message' => 'Görsel başarıyla yüklendi.']);

    $product->refresh();
    $media = $product->getFirstMedia('images');

    $this->assertNotNull($media);
    $this->assertTrue(file_exists($media->getPath()));

    // İsteğe bağlı: En az 1 media eklenmiş mi kontrol
    $this->assertGreaterThanOrEqual(1, Media::where('model_id', $product->id)->count());
}
}