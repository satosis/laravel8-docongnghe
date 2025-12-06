<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $images = [
            '1200px-Dell_logo.svg.png',
            '1743472199764-vi-vn-asus-vivobook-go-15-e1504fa-r5-nj776w-slider-1[1].jpg',
            '1743480176135-macbook-m4[1].png',
            '1743480288926-macbook-pro-14-inch-m4-max-bac-1[1].png',
            '1743481600226-24398-asus-expertbook-b1-b1502cva-nj0050w-1-f3e2f567-d424-4c30-a18c-4460cfb7f2b3-43370820-daf7-4da2-b88b-7ccb7d5b5',
            '744-jpg-v-1736503963727[1].jpg',
            '1743486803164-acer-gaming-nitro-5-2021-an515-57-ryzen-7-5800h-8gb-512gb-rtx-3060-6g-156-inch-fhd-G14339-1682143674537[1].jpg',
            '1743486885670-hp-zbook-firefly-16-g10-2023-1734576350[1].jpg',
            '2023-12-24-11-00-51-pc_dua.png',
            '2023-12-24-11-16-17-pc_cam.png',
            '2023-12-24-11-17-00-pc_chuoi.png',
            '2023-12-24-11-17-56-pc_kiwi.png',
            '2023-12-24-11-18-25-pc_vai.png',
            '2023-12-24-16-43-01-pc_meomeo.png',
            '2023-12-24-16-48-44-pc_bo.png',
            '2023-12-24-16-51-49-pc_bo.png',
            '2023-12-24-18-00-46-pc_ake.png',
            '2023-12-24-18-03-13-pc_diman.png',
            '2023-12-24-18-03-52-pc_diman.png',
            '2023-12-24-18-04-21-pc_diman.png',
            '2023-12-29-13-04-32-logo_asus.png',
            '2023-12-29-13-05-11-logo_asus.png',
            '2023-12-29-13-22-22-logo_msi.png',
            '2024-01-02-08-27-13-250-8799-pc------------i-h---c-2023--1-.jpg',
            '2024-01-03-05-08-21-pc-daonh-nghiep-1.jpg',
            '2024-01-03-05-12-54-250-9239-tnc-pc-doanh-nghiep-3.jpg',
            '2024-01-03-05-16-50-250-9240-tnc-pc-doanh-nghiep-4.jpg',
            '2024-01-10-05-27-23-PC-Snipper-300.jpg',
            '2024-01-10-05-31-03-PCGaming-NovaA4070-WH.jpg',
            '2024-01-10-05-33-30-PC Gaming - Sniper I4060Ti - BL.jpg',
            '2024-01-10-05-33-46-PC Gaming - Sniper I4060Ti - BL.jpg',
            '2024-01-21-14-47-59-pcvanphong_1.jpg',
            '2025-11-09-21-30-13-2024-01-10-05-33-46-PC Gaming - Sniper I4060Ti - BL.jpg',
            '2025-11-19-20-03-55-2024-01-10-05-31-03-PCGaming-NovaA4070-WH.jpg',
            '2025-11-19-20-13-23-2024-01-03-05-12-54-250-9239-tnc-pc-doanh-nghiep-3.jpg',
            '515pYNbpCUL._SY355_.jpg',
            'Acer44-b_37.jpg',
            'Asus44-b_35.jpg',
            'Beats Solo 3 Wireless Ten Year Edition.jpg',
            'Cáp bạc OTG IPC1.jpg',
            'Cáp bạc OTG Sony Walkman WA01.jpg',
            'Cáp đồng OTG Sony Walkman WA02.jpg',
            'HP-Compaq44-b_36.jpg',
            'Huawei42-b_30.jpg',
            'Huawei522-b_35.jpg',
            'KZ-SA08-60-Noise-Canceling-TWS-Earbuds-with-USB-C.png',
            'Lenovo522-b_29.jpg',
            'Loa Harman Kardon Onyx Studio 9.jpg',
            'Macbook44-b_41.png',
            'Meze-Audio-Liric-headphone-01.png',
            'Meze-Audio-Liric-headphone-03.png',
            'New-Original-RUIZU-M1-Bluetooth-Sport-MP3-Player-Portable-Audio-8GB-with-Built-in-Speaker-FM.jpg_640x640.jpg',
            'Nokia42-b_21.jpg',
            'OPPO42-b_9.png',
            'Realme42-b_37.png',
            'Rose-Technics-HiFi-Earphone-Dynamic-Driver-Audiophile-Earbud-OFC-Cable-Sports-Jogging-DJ-In-Ear-Monitor.jpg_640x640.jpg',
            'Samsung42-b_25.jpg',
            'Samsung522-b_30.jpg',
            'Vivo42-b_50.jpg',
            'Xiaomi42-b_45.jpg',
            'apple-macbook-air-2019-i5-16ghz-8gb-256gb-mvfl2sa-600x600.jpg',
            'apple-macbook-air-2020-i3-11ghz-8gb-256gb-600x600.jpg',
            'apple-macbook-air-mqd32sa-a-i5-5350u-600x600.jpg',
            'apple-macbook-pro-touch-2019-15-thumb-600x600.jpg',
            'apple-macbook-pro-touch-2019-i5-14ghz-8gb-256gb-m-applemacbookprotouch2019-600x600.jpg',
            'asus-530f-i3-8145u-4gb-1tb-bq185t-24-600x600.jpg',
            'asus-a512fa-i5-8265u-8gb-1tb-win10-ej552t-16-1-600x600.jpg',
            'asus-gaming-rog-strix-g531g-i7-9750h-8gb-512gb-gtx-6-600x600.jpg',
            'asus-s430fn-i5-8265u-8gb-256gb-mx150-win10-eb032t-2-1-1-1-600x600.jpg',
            'asus-s530f-i7-8565u-8gb-16gb-1tb-mx150-bq550t-7-1-600x600.jpg',
            'asus-s530fa-i5-8265u-8gb-16gb-1tb-win10-bq400t4-2-600x600.jpg',
            'asus-s530fn-i5-8265u-4gb-1tb-mx150-win10-bq128t-28-600x600.jpg',
            'asus-vivobook-a412f-i3-8145u-4gb-32gb-512gb-win10-600x600.jpg',
            'asus-vivobook-a412f-i510210u-8gb-32gb-512gb-win10-218865-600x600.jpg',
            'asus-vivobook-a412fa-i5-ek738t-600x600.jpg',
            'asus-vivobook-a512fa-i3-8145u-4gb-512gb-win10-ej1-220574copy-600x600.jpg',
            'asus-vivobook-a512fa-i5-10210u-8gb-512gb-chuot-win-1-600x600.jpg',
            'asus-vivobook-a512fl-i5-10210u-8gb-512gb-2gb-mx250-600x600.jpg',
            'asus-vivobook-s14-s431-i7-8565u-8gb-512gb-win10-e1a-1-600x600.jpg',
            'asus-vivobook-s412f-i3-8145u-4gb-512gb-ek342t3-1-1-600x600.jpg',
            'asus-vivobook-x409f-i5-8265u-8gb-1tb-win10-ek138t2-1-thumb-1-600x600.jpg',
            'asus-vivobook-x409fa-i3-8145u-4gb-512gb-win10-ek3-15-600x600.jpg',
            'asus-vivobook-x409fa-i3-ek468t-221618-600x600.jpg',
            'asus-vivobook-x409ja-i5-1035g1-8gb-512gb-win10-ek-600x600.jpg',
            'asus-vivobook-x509f-i7-8565u-8gb-mx230-win10-ej13-5-2-1-2-1-600x600.jpg',
            'asus-vivobook-x509fa-i3-8145u-4gb-512gb-chuot-win1-220575copy-600x600.jpg',
            'asus-vivobook-x509fj-i3-8145u-4gb-1tb-2gb-mx230-wi-1-600x600.jpg',
            'asus-vivobook-x509fj-i5-8265u-8gb-16gb-1tb-2gb-mx2-17-600x600.jpg',
            'asus-vivobook-x509jp-i5-ej023t-221617-600x600.jpg',
            'asus-vivobook-x509ma-br061t-220527-600x600.jpg',
            'asus-vivobook-x509u-i3-7020-4gb-1tb-chuot-win10-e-14-600x600.jpg',
            'asus-x409ja-i3-ek015t-220526-1-600x600.jpg',
            'asus-x441ma-ga024t-600x600.jpg',
            'bose-logo.jpg',
            'cap-sac-nhanh-iphone-type-c-sang-lightning-1.jpg',
            'cap-sony-muc-b12sm1-kimber-kable-cap-sony-muc-b12sm1-kimber-kable-800x800.jpg',
            'cáp samsung note 10.jpg',
            'digital-voice-recorder-hifi-mp3-music-player-bt-4-leather-strap-watch-8gb-ip67-waterproof-ruizu-k18-mp3-music-player.jpg',
            'download (1).jpg',
            'hiby pro max.jpg',
        ];

        $shortTemplates = [
            ':name với thiết kế hiện đại, tối ưu cho dân văn phòng lẫn creator.',
            'Hiệu năng của :name đủ sức chiến game và chạy ứng dụng AI mới nhất.',
            ':name hỗ trợ Wi-Fi 6/6E, sạc nhanh chuẩn USB-C thời thượng.',
            'Màn hình sắc nét, màu chuẩn trên :name giúp chỉnh sửa ảnh, video chuẩn màu.',
            ':name pin trâu, di động linh hoạt cho nhịp sống hybrid tại Việt Nam.',
            'Âm thanh sống động, mic khử ồn thông minh trên :name.',
            ':name tương thích tốt hệ sinh thái phụ kiện hot tại Việt Nam.',
            'Thiết kế mỏng nhẹ nhưng bền bỉ, :name mang vibe công nghệ Gen Z.',
        ];

        $trendHighlights = [
            'Trang bị chip thế hệ mới tối ưu AI on-device, đa nhiệm mượt mà.',
            'Màn hình tần số quét cao, viền mỏng cho trải nghiệm giải trí đã mắt.',
            'Hỗ trợ Wi-Fi 6E/7, Bluetooth 5.3 kết nối ổn định với tai nghe, đồng hồ thông minh.',
            'Pin lớn kèm sạc nhanh, đi công tác hay đi cà phê vẫn không lo hết pin.',
            'Tản nhiệt hai quạt, duy trì FPS ổn định khi chơi game hoặc livestream.',
            'Chất liệu kim loại cao cấp, hoàn thiện chuẩn flagship, hạn chế bám vân tay.',
            'Hệ loa Dolby/Hi-Res cùng micro AI khử ồn phục vụ họp online.',
            'Tích hợp nhiều cổng kết nối, hỗ trợ truyền dữ liệu tốc độ cao.',
        ];

        $usageNotes = [
            'Phù hợp nhu cầu làm việc hybrid, học online, chỉnh sửa nội dung và giải trí 4K.',
            'Combo màn hình đẹp + hiệu năng mạnh giúp xử lý deadline, edit clip TikTok, YouTube.',
            'Tương thích tốt với hệ sinh thái smart home, wearable đang thịnh hành tại Việt Nam.',
            'Đáp ứng nhu cầu dựng phim ngắn, render 3D nhẹ và chạy mô hình AI cơ bản.',
            'Dễ dàng ghép đôi cùng loa/buds, hỗ trợ gọi video rõ ràng trong mọi môi trường.',
            'Thiết kế thời trang, phù hợp xu hướng mang máy đi cà phê, coworking.',
            'Bảo mật vân tay/khuôn mặt, an tâm lưu trữ dữ liệu công việc.',
            'Bàn phím và touchpad êm, tối ưu gõ tiếng Việt Telex/VNI.',
        ];

        $usedSlugs = [];
        $products = [];

        foreach ($images as $index => $image) {
            $name = $this->makeProductName($image);
            $slug = $this->makeUniqueSlug($name, $usedSlugs);
            $price = rand(10000, 30000) * 1000;
            $priceEntry = max(0, $price - rand(500000, 2500000));
            $quantity = rand(50, 200);

            $products[] = [
                'pro_name'           => $name,
                'pro_slug'           => $slug,
                'pro_price'          => $price,
                'pro_price_entry'    => $priceEntry,
                'pro_category_id'    => rand(1, 4),
                'pro_admin_id'       => 1,
                'pro_sale'           => rand(0, 20),
                'pro_avatar'         => '/uploads/' . $image,
                'pro_view'           => 0,
                'pro_hot'            => 0,
                'pro_active'         => 1,
                'pro_pay'            => 0,
                'pro_number_import'  => $quantity,
                'pro_number'         => $quantity,
                'pro_description'    => $this->makeDescription($name, $shortTemplates),
                'pro_content'        => $this->makeContent($name, $trendHighlights, $usageNotes),
                'pro_review_total'   => 0,
                'pro_review_star'    => 0,
                'created_at'         => now(),
                'updated_at'         => now(),
            ];
        }

        DB::table('products')->insert($products);
    }

    private function makeProductName(string $fileName): string
    {
        $name = pathinfo($fileName, PATHINFO_FILENAME);
        $name = preg_replace('/[\[_\]\(\)]+/', ' ', $name);
        $name = preg_replace('/[-]+/', ' ', $name);
        $name = preg_replace('/\s+/', ' ', $name);

        return ucwords(trim($name));
    }

    private function makeUniqueSlug(string $name, array &$usedSlugs): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $suffix = 1;

        while (DB::table('products')->where('pro_slug', $slug)->exists() || isset($usedSlugs[$slug])) {
            $slug = $baseSlug . '-' . $suffix;
            $suffix++;
        }

        $usedSlugs[$slug] = true;

        return $slug;
    }

    private function makeDescription(string $name, array $templates): string
    {
        $template = $templates[array_rand($templates)];

        return str_replace(':name', $name, $template);
    }

    private function makeContent(string $name, array $highlights, array $usageNotes): string
    {
        $highlight = $highlights[array_rand($highlights)];
        $usage = $usageNotes[array_rand($usageNotes)];
        $intro = "$name cập nhật vibe công nghệ 2024-2025, tối ưu trải nghiệm người dùng Việt.";

        return $intro . ' ' . $highlight . ' ' . $usage;
    }
}
