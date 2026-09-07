<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;
use App\Models\MenuItem;
use App\Models\BranchMenuPrice;
use App\Models\Review;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 0. Seed Default Admin User
        User::updateOrCreate(
            ['email' => 'admin@rasominang.com'],
            [
                'name' => 'Administrator Raso Minang',
                'password' => Hash::make('password'),
            ]
        );

        // 1. Seed Branches
        $branchesData = [
            [
                'nama' => 'Raso Minang - Jakarta Selatan',
                'kota' => 'Jakarta Selatan',
                'alamat' => 'Jl. Senopati No. 45, Kebayoran Baru, Jakarta Selatan',
                'jam_buka' => '09:00 - 22:00',
                'kontak_whatsapp' => '6281234567890',
                'is_active' => true,
            ],
            [
                'nama' => 'Raso Minang - Bandung',
                'kota' => 'Bandung',
                'alamat' => 'Jl. R.E. Martadinata (Riau) No. 112, Bandung',
                'jam_buka' => '09:00 - 22:00',
                'kontak_whatsapp' => '6281234567891',
                'is_active' => true,
            ],
            [
                'nama' => 'Raso Minang - Surabaya',
                'kota' => 'Surabaya',
                'alamat' => 'Jl. Manyar Kertoarjo No. 78, Gubeng, Surabaya',
                'jam_buka' => '09:00 - 22:00',
                'kontak_whatsapp' => '6281234567892',
                'is_active' => true,
            ],
            [
                'nama' => 'Raso Minang - Medan',
                'kota' => 'Medan',
                'alamat' => 'Jl. S. Parman No. 21, Petisah Tengah, Medan',
                'jam_buka' => '09:00 - 22:00',
                'kontak_whatsapp' => '6281234567893',
                'is_active' => true,
            ],
            [
                'nama' => 'Raso Minang - Palembang',
                'kota' => 'Palembang',
                'alamat' => 'Jl. Jend. Sudirman No. 15, Ilir Timur I, Palembang',
                'jam_buka' => '09:00 - 22:00',
                'kontak_whatsapp' => '6281234567894',
                'is_active' => true,
            ],
            [
                'nama' => 'Raso Minang - Bukittinggi',
                'kota' => 'Bukittinggi',
                'alamat' => 'Jl. Ahmad Yani No. 8, Pasar Atas, Bukittinggi',
                'jam_buka' => '08:00 - 22:00',
                'kontak_whatsapp' => '6281234567895',
                'is_active' => true,
            ],
        ];

        $branches = [];
        foreach ($branchesData as $bData) {
            $branches[] = Branch::create($bData);
        }

        // 2. Seed Menu Items
        $menuData = [
            [
                'nama' => 'Nasi Rendang Daging Sapi',
                'kategori' => 'daging',
                'deskripsi' => 'Rendang daging sapi khas Payakumbuh dimasak perlahan selama 8 jam dengan kelapa kental & rempah warisan 1950.',
                'foto' => 'https://images.unsplash.com/photo-1565557628821-2b6a3f3c2d6e?w=700&auto=format&fit=crop&q=80',
                'badge' => 'Signature',
                'rating' => 4.9,
                'base_price' => 35000,
            ],
            [
                'nama' => 'Nasi Ayam Pop Istimewa',
                'kategori' => 'ayam',
                'deskripsi' => 'Ayam kampung muda dimasak air kelapa, digoreng kilat mentega, disajikan dengan sambal tomat cabe merah khas Bukittinggi.',
                'foto' => 'https://images.unsplash.com/photo-1598103452416-9554604aa204?w=700&auto=format&fit=crop&q=80',
                'badge' => 'Favorit',
                'rating' => 4.8,
                'base_price' => 28000,
            ],
            [
                'nama' => 'Dendeng Batokok Lado Mudo',
                'kategori' => 'daging',
                'deskripsi' => 'Daging sapi iris tipis dipipihkan lalu dipanggang arang batok dan disiram sambal lado mudo hijau harum menggiurkan.',
                'foto' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=700&auto=format&fit=crop&q=80',
                'badge' => 'Signature',
                'rating' => 4.9,
                'base_price' => 34000,
            ],
            [
                'nama' => 'Gulai Kepala Ikan Kakap',
                'kategori' => 'ikan',
                'deskripsi' => 'Kepala kakap merah segar dengan kuah gulai rempah kuning pekat, daun ruku-ruku, dan sensasi asam belimbing wuluh.',
                'foto' => 'https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?w=700&auto=format&fit=crop&q=80',
                'badge' => 'Signature',
                'rating' => 4.9,
                'base_price' => 55000,
            ],
            [
                'nama' => 'Ayam Bakar Bumbu Padang',
                'kategori' => 'ayam',
                'deskripsi' => 'Ayam bakar dengan lumuran bumbu rempah padang yang karamelisasi wangi arang batok kelapa asli.',
                'foto' => 'https://images.unsplash.com/photo-1626645738196-c2a7c87a8f58?w=700&auto=format&fit=crop&q=80',
                'badge' => 'Favorit',
                'rating' => 4.8,
                'base_price' => 29000,
            ],
            [
                'nama' => 'Nasi Ikan Patin Asam Padeh',
                'kategori' => 'ikan',
                'deskripsi' => 'Ikan patin segar bumbu asam padeh merah pedas segar tanpa santan, sangat kaya rempah serai dan daun kunyit.',
                'foto' => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?w=700&auto=format&fit=crop&q=80',
                'badge' => 'Baru',
                'rating' => 4.7,
                'base_price' => 32000,
            ],
            [
                'nama' => 'Nasi Telur Balado Barendo',
                'kategori' => 'ayam',
                'deskripsi' => 'Telur dadar barendo renyah berserat khas Payakumbuh dipadukan dengan telur bulat sambal balado merah legit.',
                'foto' => 'https://images.unsplash.com/photo-1516684732072-2c9c5ad3e2fc?w=700&auto=format&fit=crop&q=80',
                'badge' => 'Favorit',
                'rating' => 4.7,
                'base_price' => 22000,
            ],
            [
                'nama' => 'Gulai Kapau Sayur Cubadak',
                'kategori' => 'sayur',
                'deskripsi' => 'Sayur nangka muda, kacang panjang, dan kol berkuah gulai santan gurih khas los lambuang Bukittinggi.',
                'foto' => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?w=700&auto=format&fit=crop&q=80',
                'badge' => null,
                'rating' => 4.6,
                'base_price' => 18000,
            ],
            [
                'nama' => 'Sambal Ijo & Lalapan Daun Singkong',
                'kategori' => 'sayur',
                'deskripsi' => 'Sambal cabe hijau ulek kasar dengan ikan teri medan goreng kering dan rebusan pucuk daun singkong empuk.',
                'foto' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=700&auto=format&fit=crop&q=80',
                'badge' => 'Favorit',
                'rating' => 4.8,
                'base_price' => 12000,
            ],
            [
                'nama' => 'Es Tebak Asli Minang',
                'kategori' => 'minuman',
                'deskripsi' => 'Dessert es legendaris Minangkabau berisi tebak tepung beras, tape singkong ketan, cincau, sirup delima, dan santan gurih.',
                'foto' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bd?w=700&auto=format&fit=crop&q=80',
                'badge' => 'Signature',
                'rating' => 4.9,
                'base_price' => 18000,
            ],
            [
                'nama' => 'Es Teh Talua Kocok Gula Aren',
                'kategori' => 'minuman',
                'deskripsi' => 'Minuman penambah stamina racikan teh hitam pekat Minang, kuning telur ayam kampung, madu lebah, dan perasan jeruk nipis.',
                'foto' => 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?w=700&auto=format&fit=crop&q=80',
                'badge' => 'Favorit',
                'rating' => 4.8,
                'base_price' => 20000,
            ],
            [
                'nama' => 'Es Kelapa Muda Jeruk Kasturi',
                'kategori' => 'minuman',
                'deskripsi' => 'Daging dan air kelapa muda murni dipadukan dengan kesegaran asam manis perasan jeruk kasturi alami.',
                'foto' => 'https://images.unsplash.com/photo-1525686463730-8ed935685606?w=700&auto=format&fit=crop&q=80',
                'badge' => null,
                'rating' => 4.7,
                'base_price' => 15000,
            ],
        ];

        $createdMenuItems = [];
        foreach ($menuData as $mData) {
            $basePrice = $mData['base_price'];
            unset($mData['base_price']);
            
            $item = MenuItem::create(array_merge($mData, ['is_active' => true]));
            $createdMenuItems[] = $item;

            // Seed pricing for all branches
            foreach ($branches as $branch) {
                $adj = ($branch->kota === 'Jakarta Selatan') ? 2000 : 0;
                BranchMenuPrice::create([
                    'branch_id' => $branch->id,
                    'menu_item_id' => $item->id,
                    'harga' => $basePrice + $adj,
                    'is_available' => true,
                ]);
            }
        }

        // 3. Seed Reviews
        $reviewsData = [
            [
                'nama_pelanggan' => 'H. Ahmad Syukri, S.H.',
                'rating' => 5,
                'komentar' => 'Rendang dagingnya luar biasa otentik! Bumbu hitam meresap sampai ke serat terdalam daging. Mengingatkan masakan nenek di Bukittinggi.',
                'is_approved' => true,
                'branch_id' => $branches[0]->id,
            ],
            [
                'nama_pelanggan' => 'Siti Nurhaliza Putri',
                'rating' => 5,
                'komentar' => 'Ayam pop lembut luar biasa, sambal lado merah tomatnya juara. Suasana restorannya bersih dan nuansa Minang-nya terasa sangat elegan.',
                'is_approved' => true,
                'branch_id' => $branches[1]->id,
            ],
            [
                'nama_pelanggan' => 'Budi Santoso & Keluarga',
                'rating' => 5,
                'komentar' => 'Gulai kepala ikan kakapnya porsi mantap, kuahnya kental gurih asam segar. Wajib pesan Es Tebak untuk penutup. Pelayanan sangat cepat!',
                'is_approved' => true,
                'branch_id' => $branches[2]->id,
            ],
            [
                'nama_pelanggan' => 'dr. Dian Pratama',
                'rating' => 5,
                'komentar' => 'Dendeng batokok lado mudo terbaik di kota ini! Dagingnya empuk tidak keras, aroma asapnya harum. Langganan tetap setiap akhir pekan.',
                'is_approved' => true,
                'branch_id' => $branches[3]->id,
            ],
            [
                'nama_pelanggan' => 'Rendra Gunawan',
                'rating' => 4,
                'komentar' => 'Makanannya enak-enak, sambal ijonya mantap. Tempatnya nyaman untuk makan bersama keluarga.',
                'is_approved' => false,
                'branch_id' => $branches[0]->id,
            ],
        ];

        foreach ($reviewsData as $rData) {
            Review::create($rData);
        }

        // 4. Seed Sample Orders with Items
        $ordersData = [
            [
                'branch_id' => $branches[0]->id,
                'customer_name' => 'Faris Pratama',
                'customer_phone' => '081298765432',
                'method' => 'dine-in',
                'status' => 'cooking',
                'notes' => 'Meja 04, sambal ijo dipisah',
                'items' => [
                    ['item_index' => 0, 'qty' => 2, 'price' => 37000], // Rendang
                    ['item_index' => 1, 'qty' => 1, 'price' => 30000], // Ayam Pop
                    ['item_index' => 9, 'qty' => 2, 'price' => 20000], // Es Tebak
                ]
            ],
            [
                'branch_id' => $branches[0]->id,
                'customer_name' => 'Anisa Rahmawati',
                'customer_phone' => '081311223344',
                'method' => 'delivery',
                'status' => 'pending',
                'notes' => 'Gedung Menara Mandiri Lt. 12, mohon sambal merah ekstra',
                'items' => [
                    ['item_index' => 0, 'qty' => 3, 'price' => 37000], // Rendang
                    ['item_index' => 2, 'qty' => 2, 'price' => 36000], // Dendeng
                    ['item_index' => 10, 'qty' => 3, 'price' => 22000], // Es Teh Talua
                ]
            ],
            [
                'branch_id' => $branches[1]->id,
                'customer_name' => 'Hendro Wijaya',
                'customer_phone' => '085788990011',
                'method' => 'online',
                'status' => 'ready',
                'notes' => 'Akan diambil jam 12:30 WIB',
                'items' => [
                    ['item_index' => 3, 'qty' => 1, 'price' => 55000], // Gulai Kepala Kakap
                    ['item_index' => 7, 'qty' => 2, 'price' => 18000], // Sayur Kapau
                    ['item_index' => 11, 'qty' => 2, 'price' => 15000], // Es Kelapa
                ]
            ],
            [
                'branch_id' => $branches[2]->id,
                'customer_name' => 'Maya Indira',
                'customer_phone' => '082144556677',
                'method' => 'dine-in',
                'status' => 'confirmed',
                'notes' => 'Meja VIP 01, acara ulang tahun keluarga',
                'items' => [
                    ['item_index' => 0, 'qty' => 5, 'price' => 35000],
                    ['item_index' => 1, 'qty' => 5, 'price' => 28000],
                    ['item_index' => 6, 'qty' => 4, 'price' => 22000],
                    ['item_index' => 9, 'qty' => 8, 'price' => 18000],
                ]
            ],
            [
                'branch_id' => $branches[5]->id,
                'customer_name' => 'Bapak Zulkifli',
                'customer_phone' => '081900112233',
                'method' => 'dine-in',
                'status' => 'completed',
                'notes' => 'Rombongan wisata Bukittinggi',
                'items' => [
                    ['item_index' => 2, 'qty' => 4, 'price' => 34000],
                    ['item_index' => 4, 'qty' => 4, 'price' => 29000],
                    ['item_index' => 7, 'qty' => 4, 'price' => 18000],
                ]
            ],
            [
                'branch_id' => $branches[3]->id,
                'customer_name' => 'drg. Ratna Sari',
                'customer_phone' => '081277889900',
                'method' => 'delivery',
                'status' => 'completed',
                'notes' => 'Klinik Sehat Medika',
                'items' => [
                    ['item_index' => 0, 'qty' => 2, 'price' => 35000],
                    ['item_index' => 5, 'qty' => 2, 'price' => 32000],
                ]
            ],
        ];

        foreach ($ordersData as $oData) {
            $items = $oData['items'];
            unset($oData['items']);

            $total = 0;
            foreach ($items as $item) {
                $total += ($item['qty'] * $item['price']);
            }

            $order = Order::create(array_merge($oData, ['total' => $total]));

            foreach ($items as $item) {
                $menuItem = $createdMenuItems[$item['item_index']];
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $menuItem->id,
                    'quantity' => $item['qty'],
                    'price' => $item['price'],
                ]);
            }
        }
    }
}
