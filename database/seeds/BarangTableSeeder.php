<?php

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $barang = [
            [
                'name' => 'Gelas Mineral',
                'point' => 3000,
                'type' => 'plastik'
            ],
            [
                'name' => 'Botol Campur',
                'point' => 2000,
                'type' => 'plastik'
            ],
            [
                'name' => 'Kaset CD',
                'point' => 2000,
                'type' => 'plastik'
            ],
            [
                'name' => 'Gelas ale-ale/warna',
                'point' => 1500,
                'type' => 'plastik'
            ],
            [
                'name' => 'Kresek Warna',
                'point' => 200,
                'type' => 'plastik'
            ],
            [
                'name' => 'Plastik Refill Minyak Goreng',
                'point' => 300,
                'type' => 'plastik'
            ],
            [
                'name' => 'Glansing Utuh',
                'point' => 500,
                'type' => 'plastik'
            ],
            // Kertas
            [
                'name' => 'Kertas Putih/HVS',
                'point' => 1500,
                'type' => 'kertas'
            ],
            [
                'name' => 'Kertas Buram',
                'point' => 1000,
                'type' => 'kertas'
            ],
            [
                'name' => 'Koran Bagus',
                'point' => 1000,
                'type' => 'kertas'
            ],
            [
                'name' => 'Kardus',
                'point' => 1300,
                'type' => 'kertas'
            ],
            [
                'name' => 'Duplek/Majalah',
                'point' => 300,
                'type' => 'kertas'
            ],
            [
                'name' => 'Kertas Semen (per Lembar)',
                'point' => 150,
                'type' => 'kertas'
            ],
            //Logam
            [
                'name' => 'Aluminium',
                'point' => 7000,
                'type' => 'logam'
            ],
            [
                'name' => 'Besi',
                'point' => 2000,
                'type' => 'logam'
            ],
            [
                'name' => 'Kaleng / Omplong',
                'point' => 1000,
                'type' => 'logam'
            ],
            [
                'name' => 'Seng',
                'point' => 500,
                'type' => 'logam'
            ],
            // Kaca
            [
                'name' => 'Botol Fanta/Sprite/Coca Cola',
                'point' => 200,
                'type' => 'kaca'
            ],
            [
                'name' => 'Botol Kecap Kecil',
                'point' => 200,
                'type' => 'kaca'
            ],
            [
                'name' => 'Botol Kecap Besar',
                'point' => 500,
                'type' => 'kaca'
            ],
            [
                'name' => 'Botol Sirup',
                'point' => 100,
                'type' => 'kaca'
            ],
            [
                'name' => 'Botol Mintak Goreng orang-aring',
                'point' => 250,
                'type' => 'kaca'
            ],
            [
                'name' => 'Botol Minyak Tawon',
                'point' => 500,
                'type' => 'kaca'
            ],
            [
                'name' => 'Botol GPU/parfum',
                'point' => 100,
                'type' => 'kaca'
            ],
            // lain
            [
                'name' => 'Jelantah',
                'point' => 3500,
                'type' => 'lain'
            ],
            [
                'name' => 'Sepatu / Sandal',
                'point' => 200,
                'type' => 'lain'
            ],
        ];

        foreach ($barang as $b) {
            Barang::create([
                'name' => $b['name'],
                'type' => $b['type'],
                'point' => $b['point']
            ]);
        }

    }
}
