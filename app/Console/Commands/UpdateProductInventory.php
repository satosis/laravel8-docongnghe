<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class UpdateProductInventory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:refresh-amounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign fresh quantities, names, and technology-focused images to products.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->info('Updating product quantities, names, and images...');

        $catalog = $this->catalog();

        Product::query()
            ->orderBy('id')
            ->each(function (Product $product, int $index) use ($catalog) {
                $entry = $catalog[$index % count($catalog)];

                $product->pro_name = $entry['name'];
                $product->pro_slug = Str::slug($entry['name'] . '-' . $product->id);
                $product->pro_avatar = $entry['avatar'];
                $product->pro_number = rand(100, 200);
                $product->updated_at = Carbon::now();

                $product->save();
            });

        $this->info('All products updated successfully.');
    }

    /**
     * Build a diverse set of technology products with representative images.
     */
    private function catalog(): array
    {
        return [
            [
                'name'   => 'Dell XPS 13 Plus OLED',
                'avatar' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'name'   => 'Sony WH-1000XM5 Wireless Headphones',
                'avatar' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'name'   => 'Apple Watch Ultra Titanium',
                'avatar' => 'https://images.unsplash.com/photo-1505740420928-923f8c09a4df?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'name'   => 'Nintendo Switch OLED',
                'avatar' => 'https://images.unsplash.com/photo-1511512578047-dfb367046420?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'name'   => 'Logitech MX Mechanical Keyboard',
                'avatar' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'name'   => 'Canon EOS R6 Mirrorless Camera',
                'avatar' => 'https://images.unsplash.com/photo-1519183071298-a2962be90b8e?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'name'   => 'Samsung Odyssey G9 Curved Monitor',
                'avatar' => 'https://images.unsplash.com/photo-1587202372775-a5ec2cb0d805?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'name'   => 'DJI Mini 4 Pro Drone',
                'avatar' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'name'   => 'ASUS ROG Ally Gaming Handheld',
                'avatar' => 'https://images.unsplash.com/photo-1612178537253-579c557a96db?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'name'   => 'Google Nest Learning Thermostat',
                'avatar' => 'https://images.unsplash.com/photo-1512412046876-f386342eddb3?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'name'   => 'TP-Link Archer AX6000 Wi-Fi 6 Router',
                'avatar' => 'https://images.unsplash.com/photo-1587825140708-dfaf72ae4b04?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'name'   => 'Valve Steam Deck OLED',
                'avatar' => 'https://images.unsplash.com/photo-1606813907291-03c9b5dcd3a7?auto=format&fit=crop&w=1200&q=80',
            ],
        ];
    }
}
