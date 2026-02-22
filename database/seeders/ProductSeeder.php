<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        if ($categories->isEmpty()) {
            $this->command->warn('No categories found. Run CategorySeeder first.');
            return;
        }

        Storage::disk('public')->makeDirectory('products');

        $products = $this->loadProductsFromJson();

        if (empty($products)) {
            $this->command->error('No products found in JSON file.');
            return;
        }

        $created = 0;
        foreach ($products as $productData) {
            $imagePath = $this->downloadImage($productData['image_url'] ?? null, $created);

            $category = $categories->where('name', $productData['category'])->first();
            if (!$category) {
                $this->command->warn("Category '{$productData['category']}' not found for product '{$productData['name']}'. Skipping.");
                continue;
            }

            Product::create([
                'name' => $productData['name'],
                'description' => $productData['description'],
                'price' => (float) $productData['price'],
                'image' => $imagePath,
                'category_id' => $category->id,
            ]);

            $created++;
        }

        $this->command->info("Created {$created} tableware products with images.");
    }

    /**
     * Load products from JSON file.
     */
    protected function loadProductsFromJson(): array
    {
        $jsonPath = database_path('data/products.json');

        if (!File::exists($jsonPath)) {
            $this->command->error("JSON file not found: {$jsonPath}");
            return [];
        }

        $json = File::get($jsonPath);
        $products = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->command->error('Invalid JSON: ' . json_last_error_msg());
            return [];
        }

        return $products ?? [];
    }

    /**
     * Download image from URL and store in public disk.
     */
    protected function downloadImage(?string $url, int $index): string
    {
        if (empty($url)) {
            $this->command->warn("No image URL provided for product {$index}. Skipping image.");
            return '';
        }

        $filename = 'products/tableware-' . uniqid() . '.jpg';

        try {
            $response = Http::timeout(15)->get($url);
            if ($response->successful()) {
                Storage::disk('public')->put($filename, $response->body());
                return $filename;
            } else {
                $this->command->warn("Failed to download image for product {$index}: HTTP {$response->status()}");
            }
        } catch (\Throwable $e) {
            $this->command->warn("Image download failed for product {$index}: " . $e->getMessage());
        }

        return '';
    }
}
