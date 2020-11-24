<?php

use App\Models\Auth\User;
use App\Models\Warga;
use Illuminate\Database\Seeder;

/**
 * Class BimbinganTableSeeder.
 */
class WargaTableSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();
        
        $user = User::find(3);
        
        $user->warga()->create([
            'point_total' => 0
        ]);

        
        $this->enableForeignKeys();
    }
}
