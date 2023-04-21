<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables([
            'usertypes',
            'business',
            'branches',
            'cashboxes',
            'users',
            'menu_groups',
            'menu_options',
            'access',
            'categories',
            'concepts',
            'floors',
            'units',
            'room_types',
            'services',
            'rooms',
            'products',
            'payments',
            'settings',
            'people',
            'processtypes',
            'bookings',
            // 'processes',
        ]);

        $this->call([
            UserTypeSeeder::class,
            BusinessSeeder::class,
            BranchSeeder::class,
            CashBoxSeeder::class,
            UserSeeder::class,
            MenuGroupSeeder::class,
            MenuOptionSeeder::class,
            AccessSeeder::class,
            CategorySeeder::class,
            ConceptSeeder::class,
            FloorSeeder::class,
            UnitSeeder::class,
            RoomTyperSeeder::class,
            ServiceSeeder::class,
            RoomSeeder::class,
            ProductSeeder::class,
            PaymentSeeder::class,
            SettingSeeder::class,
            PeopleSeeder::class,
            ProcessTypeSeeder::class,
            BookingSeeder::class,
            // ProcessSeeder::class,
        ]);
    }

    protected function truncateTables(array $tablas)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        foreach ($tablas as $tabla) {
            DB::table($tabla)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}