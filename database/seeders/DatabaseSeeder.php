<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('users')->insert([
            [
                'name' => 'test1',
                'email' => 'test1@test.com',
                'isAdmin' => 0,
                'password' => bcrypt('123456'),
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'test2',
                'email' => 'test2@test.com',
                'isAdmin' => 0,
                'password' => bcrypt('123456'),
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'test3',
                'email' => 'test3@test.com',
                'isAdmin' => 0,
                'password' => bcrypt('123456'),
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'test4',
                'email' => 'test4@test.com',
                'isAdmin' => 1,
                'password' => bcrypt('123456'),
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
            ],
        ]);

        DB::table('orders')->insert([
            [
                'user_id' => 1,
                'sum' => 13000,
                'state' => 'CANCELED',
                'order_date' => now(),
            ],
            [
                'user_id' => 1,
                'sum' => 21000,
                'state' => 'FINISHED',
                'order_date' => now(),
            ],
            [
                'user_id' => 2,
                'sum' => 18000,
                'state' => 'FINISHED',
                'order_date' => now(),
            ],
            [
                'user_id' => 3,
                'sum' => 15000,
                'state' => 'SHIPPING',
                'order_date' => now(),
            ],
        ]);

        DB::table('products')->insert([
            [
                'name' => 'BMW R18',
                'price' => 5000,
                'productId' => 'R18150',
                'state' => 'AVAILABLE',
                'stock' => 12
            ],
            [
                'name' => 'KAWASAKI 1000',
                'price' => 8000,
                'productId' => 'K1000',
                'state' => 'OUT OF STOCK',
                'stock' => 0
            ],
        ]);

        DB::table('order__products')->insert([
            [
                'order_id' => 1,
                'product_id' => 1,
                'amount' => 1,
            ],
            [
                'order_id' => 1,
                'product_id' => 2,
                'amount' => 1,
            ],
            [
                'order_id' => 2,
                'product_id' => 1,
                'amount' => 1,
            ],
            [
                'order_id' => 2,
                'product_id' => 2,
                'amount' => 2,
            ],
            [
                'order_id' => 3,
                'product_id' => 1,
                'amount' => 2,
            ],
            [
                'order_id' => 3,
                'product_id' => 2,
                'amount' => 1,
            ],
            [
                'order_id' => 4,
                'product_id' => 1,
                'amount' => 3,
            ],
        ]);
    }
}
