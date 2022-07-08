<?php


    use Illuminate\Database\Seeder;

    class DatabaseSeeder extends Seeder
    {
        /**
         * Seed the application's database.
         *
         * @return void
         */
        public function run() {
            $user = App\User::create([
                "name" => '21Twelve Admin',
                "email" => 'admin@admin.com',
                'email_verified_at' => '2021-08-28 09:03:01',
                "password" => bcrypt('admin123'),
            ]);


            $admin = App\Role::create([
                "name" => 'Admin',
                "slug" => 'admin'
            ]);

            $isManager = App\Role::create([
                "name" => 'Manager',
                "slug" => 'manager'
            ]);

            $isContentEditor = App\Role::create([
                "name" => 'Editor',
                "slug" => 'editor'
            ]);

            DB::table('users_roles')->insert(
                ['user_id' => 1, 'role_id' => 1]
            );
        }

    }
