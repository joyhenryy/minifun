<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::updateOrCreate(
            ['email' => 'admin@minifun.com'],
            [
                'name' => 'MINIFUN Admin',
                'password' => Hash::make('password'),
            ]
        );

        // Categories
        $categories = [
            ['id' => 1, 'name' => 'Box & Rak Hotwheels', 'slug' => 'box-rak-hotwheels'],
            ['id' => 2, 'name' => 'Akrilik Custom', 'slug' => 'akrilik-custom'],
            ['id' => 3, 'name' => 'Packing Tambahan', 'slug' => 'packing-tambahan'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // Mapping from old/provided Category ID to new Category ID
        // 6 (Racks/Boxes) -> 1 (Box & Rak Hotwheels)
        // 7 (Custom) -> 2 (Akrilik Custom)
        // 1 (Packing) -> 3 (Packing Tambahan) - based on context "Packing Kardus" having ID 1 in input but belonging to Packing category
        
        // Products
        $products = [
            [
                'name' => 'Box Diecast Akrilik (1:64) model pintu STACKABLE',
                'slug' => 'box-diecast-akrilik-164-model-pintu-stackable',
                'description' => 'MINIFUN "BERIKAN KESAN TERBAIK UNTUK DIECASTMU"📌 𝗗𝗘𝗧𝗔𝗜𝗟 𝗣𝗥𝗢𝗗𝗨𝗞 :Untuk Diecast 1:64Dimensi Dalam 9 cm x4,5 cm x 4,5 cmSpesifikasi material : Acrylic bening 2 mm100% laser cuttingNON ASSAMBLERakit (DIY)📌 𝗡𝗢𝗧𝗘•  DieCast diatas hanya sebagai contoh display• Produk yang sudah dibeli dan diatur pengiriman TIDAK DAPAT ditukar/dibatalkan• Segala bentuk kerusakan barang/kemasan akibat pengiriman ekspedisi DILUAR TANGGUNG JAWAB kami• Untuk meminimalisir kerusakan pada saat pengiriman, diwajibkan untuk menambahkan produk "𝐁𝐔𝐁𝐁𝐋𝐄 𝐖𝐑𝐀𝐏/𝐃𝐔𝐒" pada etalase produk kami• (Tutorial Pemasangan ada pada laman utama katalog produk)',
                'price' => 10000.0,
                'shopee_url' => 'https://www.google.com/search?q=https://shopee.co.id/Box-Diecast-Akrilik-(1-64)-model-pintu-STACKABLE-i.1178230185.25661953226%3FextraParams%3D%257B%2522display_model_id%2522%253A184903405923%252C%2522model_selection_logic%2522%253A3%257D',
                'is_featured' => true,
                'category_id' => 1,
            ],
            [
                'name' => 'BOX AKRILIK DIECAST MINI GT - stackable (bisa disusun)',
                'slug' => 'box-akrilik-diecast-mini-gt-stackable-bisa-disusun',
                'description' => 'MINIFUN "BERIKAN KESAN TERBAIK UNTUK DIECASTMU"📌 𝗗𝗘𝗧𝗔𝗜𝗟 𝗣𝗥𝗢𝗗𝗨𝗞 :Untuk Diecast 1:64 (Mini GT)Spesifikasi material : Acrylic bening 2 mmUkuran Keselurahan Box P x L x T: 10.2 x 4.8 x 9.7Ukuran lantai 1 Box P x L x T: 10.2 x 4.8 x 4.7Ukuran lantai 2 Box P x L x T: 10.2 x 4.8 x 4.8100% laser cuttingstackable (bisa ditumpuk)NON ASSAMBLERakit (DIY)📌 𝗡𝗢𝗧𝗘•  DieCast diatas hanya sebagai contoh display• Produk yang sudah dibeli dan diatur pengiriman TIDAK DAPAT ditukar/dibatalkan• Segala bentuk kerusakan barang/kemasan akibat pengiriman ekspedisi DILUAR TANGGUNG JAWAB kami• Untuk meminimalisir kerusakan pada saat pengiriman, diwajibkan untuk menambahkan produk "𝐁𝐔𝐁𝐁𝐋𝐄 𝐖𝐑𝐀𝐏/𝐃𝐔𝐒" pada etalase produk kami• (Tutorial Pemasangan ada pada laman utama katalog produk)',
                'price' => 31200.0,
                'shopee_url' => 'https://www.google.com/search?q=https://shopee.co.id/BOX-AKRILIK-DIECAST-MINI-GT-stackable-(bisa-disusun)-i.1178230185.25465393401%3FextraParams%3D%257B%2522display_model_id%2522%253A405446419970%252C%2522model_selection_logic%2522%253A2%257D',
                'is_featured' => true,
                'category_id' => 1,
            ],
            [
                'name' => 'RAK HOTWHEELS ISI 30 SLOT SLIM – Rak Diecast Skala 1:64, Rak Akrilik, Rak Miniatur Mobil',
                'slug' => 'rak-hotwheels-isi-30-slot-slim-rak-diecast-skala-164-rak-akrilik-rak-miniatur-mobil',
                'description' => 'Tunjukkan koleksi diecast Anda dengan gaya dan perlindungan maksimal! Rak Hot Wheels 30 slot ini dibuat dari akrilik yang kokoh dan bening, menjaga koleksi tetap aman dari debu dan goresan. Dengan desain bingkai merah dan hitam elegan dan pintu sliding transparan, koleksi Anda akan terlihat rapi dan menarik.Spesifikasi Produk:Material: Akrilik merah 2mm, akrilik bening 2mm, akrilik bening 1,8mmUkuran: Panjang 46,2 cm x Tinggi 25,4 cm x Lebar 4,9 cmKapasitas: 30 slot untuk diecast skala 1:64 (Hot Wheels, Tomica, Matchbox, dll)Pintu: Sliding (geser) – mudah dibuka, rapat saat ditutupFitur: Bisa dipasang di dinding (lubang gantung sudah tersedia) atau diletakkan di mejaFinishing: Potongan presisi, rapi, dan eleganKelebihan Produk:✔ Melindungi koleksi dari debu, kotoran, dan goresan✔ Desain hemat tempat, cocok untuk meja atau dinding✔ Tampilan premium – bingkai merah dan hitam & akrilik jernih tebal✔ Bahan berkualitas tinggi, awet, dan mudah dibersihkanCocok untuk: Pajangan koleksi Hot Wheels, Tomica, Matchbox, Majorette, dan diecast skala 1:64 lainnya.MOHON PERHATIKAN KETENTUAN KOMPLAIN DI HALAMAN TERAKHIR KATALOG!!!',
                'price' => 150200.0,
                'shopee_url' => 'https://shopee.co.id/RAK-HOTWHEELS-ISI-30-SLOT-SLIM-%E2%80%93-Rak-Diecast-Skala-1-64-Rak-Akrilik-Rak-Miniatur-Mobil-i.1178230185.41712233305?extraParams=%7B%22display_model_id%22%3A281023919738%2C%22model_selection_logic%22%3A3%7D',
                'is_featured' => false,
                'category_id' => 1,
            ],
            [
                'name' => 'Blister Card Box AKrilik HW Reguler',
                'slug' => 'blister-card-box-akrilik-hw-reguler',
                'description' => '📌 𝗗𝗘𝗧𝗔𝗜𝗟 𝗣𝗥𝗢𝗗𝗨𝗞 :Untuk Diecast: 1:64Blister Reguler CardSpesifikasi material : Acrylic bening 2 mm100% laser cuttingPintu Buka TutupKunci Pintu BoxRakit (DIY)📌 𝗡𝗢𝗧𝗘• DieCast diatas hanya sebagai contoh display• Produk yang sudah dibeli dan diatur pengiriman TIDAK DAPAT ditukar/dibatalkan• Segala bentuk kerusakan barang/kemasan akibat pengiriman ekspedisi DILUAR TANGGUNG JAWAB kami• Untuk meminimalisir kerusakan pada saat pengiriman, diwajibkan untuk menambahkan produk "𝐁𝐔𝐁𝐁𝐋𝐄 𝐖𝐑𝐀𝐏/𝐃𝐔𝐒" pada etalase produk kami',
                'price' => 40000.0,
                'shopee_url' => 'https://www.google.com/search?q=https://shopee.co.id/Blister-Card-Box-AKrilik-HW-Reguler-i.1178230185.24911960055%3FextraParams%3D%257B%2522display_model_id%2522%253A29770387591%252C%2522model_selection_logic%2522%253A3%257D',
                'is_featured' => false,
                'category_id' => 1,
            ],
            [
                'name' => 'Rak Hotwheels Serong Isi 24 - Skala 1:64, Rak Akrilik Serong 45°',
                'slug' => 'rak-hotwheels-serong-isi-24-skala-164-rak-akrilik-serong-45',
                'description' => 'MINIFUN "BERIKAN KESAN TERBAIK UNTUK DIECASTMU"𝗗𝗘𝗧𝗔𝗜𝗟 𝗣𝗥𝗢𝗗𝗨𝗞 :Untuk Diecast 1:64Dimensi Dalam per kolom 9 cm x4,5 cm x 4,5 cmJumlah kolom : 24Spesifikasi material : full Acrylic 2 mm (bening, merah, dan putih susu)100% laser cuttingKondisi: Sudah dirakit',
                'price' => 165500.0,
                'shopee_url' => 'https://www.google.com/search?q=https://shopee.co.id/Rak-Hotwheels-Serong-Isi-24-Skala-1-64-Rak-Akrilik-Serong-45%25C2%25B0-i.1178230185.26124575343%3FextraParams%3D%257B%2522display_model_id%2522%253A291874748355%252C%2522model_selection_logic%2522%253A3%257D',
                'is_featured' => false,
                'category_id' => 1,
            ],
            [
                'name' => 'RAK HOTWHEELS ISI 20 SLOT SLIM– Rak Diecast Skala 1:64, Rak Akrilik, Rak Miniatur Mobil',
                'slug' => 'rak-hotwheels-isi-20-slot-slim-rak-diecast-skala-164-rak-akrilik-rak-miniatur-mobil',
                'description' => 'Pajang koleksi diecast kesayangan  dengan rapi dan aman! Rak Hot Wheels 20 slot ini . Dibuat dari akrilik premium yang tebal, kokoh, dan bening, rak ini melindungi koleksi dari debu dan goresan, sekaligus memberikan tampilan yang elegan.Spesifikasi Produk:Material: Akrilik merah 2mm, akrilik bening 2mm, akrilik bening 1,8mmUkuran: Panjang 31 cm x Tinggi 25,4 cm x Lebar 4,9 cmKapasitas: 20 slot untuk diecast skala 1:64 (Hot Wheels, Tomica, Matchbox, dll)Pintu: Sliding (geser) – mudah dibuka, rapat saat ditutupFitur: Bisa dipasang di dinding (lubang gantung sudah tersedia) atau diletakkan di mejaFinishing: Potongan presisi, rapi, dan eleganKelebihan Produk:✔ Melindungi koleksi dari debu, kotoran, dan goresan✔ Desain hemat tempat, cocok untuk meja atau dinding✔ Tampilan premium – bingkai merah dan hitam & akrilik jernih tebal✔ Bahan berkualitas tinggi, awet, dan mudah dibersihkanCocok untuk: Pajangan koleksi Hot Wheels, Tomica, Matchbox, Majorette, dan diecast skala 1:64 lainnya.MOHON PERHATIKAN KETENTUAN KOMPLAIN DI HALAMAN TERAKHIR KATALOG!!!',
                'price' => 125000.0,
                'shopee_url' => 'https://www.google.com/search?q=https://shopee.co.id/RAK-HOTWHEELS-ISI-20-SLOT-SLIM%25E2%2580%2593-Rak-Diecast-Skala-1-64-Rak-Akrilik-Rak-Miniatur-Mobil-i.1178230185.40462265277%3FextraParams%3D%257B%2522display_model_id%2522%253A296853138892%252C%2522model_selection_logic%2522%253A3%257D',
                'is_featured' => false,
                'category_id' => 1,
            ],
            [
                'name' => 'Rak Hotwheels Slim Fit Edition isi 5 - Skala 1:64, No Header, Rak Akrilik',
                'slug' => 'rak-hotwheels-slim-fit-edition-isi-5-skala-1-64-no-header-rak-akrilik',
                'description' => '📌 𝗗𝗘𝗧𝗔𝗜𝗟 𝗣𝗥𝗢𝗗𝗨𝗞 :Untuk Diecast: 1:64Spesifikasi material : Acrylic bening 2 mm100% laser cuttingukuran masing masing blok kotak PxLxT : 9x4x4Tinggal pakai📌 𝗡𝗢𝗧𝗘•  DieCast diatas hanya sebagai contoh display• Produk yang sudah dibeli dan diatur pengiriman TIDAK DAPAT ditukar/dibatalkan• Segala bentuk kerusakan barang/kemasan akibat pengiriman ekspedisi DILUAR TANGGUNG JAWAB kami• Untuk meminimalisir kerusakan pada saat pengiriman, diwajibkan untuk menambahkan produk "𝐁𝐔𝐁𝐁𝐋𝐄 𝐖𝐑𝐀𝐏/𝐃𝐔𝐒" pada etalase produk kami',
                'price' => 42000.0,
                'shopee_url' => 'https://www.google.com/search?q=https://shopee.co.id/Rak-Hotwheels-Slim-Fit-Edition-isi-5-Skala-1-64-No-Header-Rak-Akrilik-i.1178230185.25569238480%3FextraParams%3D%257B%2522display_model_id%2522%253A245714575146%252C%2522model_selection_logic%2522%253A2%257D',
                'is_featured' => true,
                'category_id' => 1,
            ],
            [
                'name' => 'Akrilik Box Custom Bongkar Pasang 2-3mm',
                'slug' => 'akrilik-box-custom-bongkar-pasang-2-3mm',
                'description' => 'Detail produkAkrilik ketebalan 2mmAkrilik ketenalan 3mmJenis boxBox bongkar pasangBox patenHow to Order-Diskusikan dahulu kepada kami perihal pesanan anda melalui fitur chat atau langsung hubungi admin-Admin akan menghitung harga box sesuai dengan pesanan anda-Setelah harga disepakati silakan melakukan CO dengan menyesuaikan harga total dari admin-Contoh: admin memberikan harga 50rb silakan CO 50X pada produk ini',
                'price' => 1000.0,
                'shopee_url' => 'https://www.google.com/search?q=https://shopee.co.id/Akrilik-Box-Custom-Bongkar-Pasang-2-3mm-i.1178230185.26053917160%3FextraParams%3D%257B%2522display_model_id%2522%253A197608666660%252C%2522model_selection_logic%2522%253A3%257D',
                'is_featured' => true,
                'category_id' => 2,
            ],
            [
                'name' => 'TAMBAHAN Packing Bubble Wrap + Kardus',
                'slug' => 'tambahan-packing-bubble-wrap-kardus',
                'description' => 'Link untuk tambahan packing kemasan kaca / produk lain untuk perlindungan gandaUntuk menjaga keamanan barang ( terutama produk packing kaca ) bisa menambahkan tambahan packing',
                'price' => 5000.0,
                'shopee_url' => 'https://www.google.com/search?q=https://shopee.co.id/TAMBAHAN-Packing-Bubble-Wrap-Kardus-i.1178230185.24313346196%3FextraParams%3D%257B%2522display_model_id%2522%253A127843822791%252C%2522model_selection_logic%2522%253A3%257D',
                'is_featured' => false,
                'category_id' => 3,
            ],
            [
                'name' => 'Packing Kardus',
                'slug' => 'packing-kardus',
                'description' => 'Silakan order kardus bila paket anda ingin lebih aman, tanpa order kardus maka packing seadanya.ini kardus tambahan packing bukan kardus utuh kaya di gambar, gambar hanya ilustrasi saja ya.extra packing kardus untuk produk akrilik agar lebih aman dalam pengiriman.',
                'price' => 3000.0,
                'shopee_url' => 'https://www.google.com/search?q=https://shopee.co.id/Packing-Kardus-i.1178230185.24663341851%3FextraParams%3D%257B%2522display_model_id%2522%253A250331243027%252C%2522model_selection_logic%2522%253A3%257D',
                'is_featured' => false,
                'category_id' => 3,
            ],
        ];

        foreach ($products as $prod) {
            Product::updateOrCreate(['slug' => $prod['slug']], $prod);
        }
    }
}
