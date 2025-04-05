<?php 
// database/seeders/PermissionsSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        
        DB::table('permissions')->insert([
            ['permission_name' => 'admin'],
            ['permission_name' => 'user'],
            // Bạn có thể thêm các quyền khác tại đây
        ]);
    }
}
