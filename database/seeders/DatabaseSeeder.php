<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            DB::table('projects')->insert([
                'project_name' => $faker->unique()->company . ' Project',
                'initial_balance' => $faker->numberBetween(10000, 100000),
                'status' => $faker->numberBetween(0, 1),
                'note' => $faker->text(100)
            ]);
        }

        for ($i = 0; $i < 100; $i++) {
            DB::table('suppliers')->insert([
                'supplier_name' => $faker->unique()->name,
                'supplier_phone' => '01729277768',
                'supplier_address' => $faker->text(50),
                'note' => $faker->text(100)
            ]);
        }

        for ($i = 0; $i < 500; $i++) {
            // Randomly decide which field to fill
            if (rand(0, 1) === 1) {
                // Fill deposit, leave expense null
                $deposit = $faker->numberBetween(1000, 10000);
                $expense = null;
            } else {
                // Fill expense, leave deposit null
                $deposit = null;
                $expense = $faker->numberBetween(1000, 10000);
            }

            DB::table('profile')->insert([
                'date' => $faker->date(),
                'note' => $faker->text(100),
                'deposit_amount' => $deposit,
                'expense_amount' => $expense,
            ]);
        }

        for ($i = 0; $i < 1000; $i++) {

            // Get a random project_id from projects table
            $randomProjectId = DB::table('projects')->inRandomOrder()->value('project_id');

            // Get a random supplier_id from suppliers table
            $randomSupplierId = DB::table('suppliers')->inRandomOrder()->value('supplier_id');

            // Randomly choose debit or credit (as you did earlier)
            if (rand(0, 1) === 1) {
                $debit = $faker->numberBetween(1000, 10000);
                $credit = null;
            } else {
                $debit = null;
                $credit = $faker->numberBetween(1000, 10000);
            }

            DB::table('debit_credits')->insert([
                'project_id' => $randomProjectId,
                'supplier_id' => $randomSupplierId,
                'note' => $faker->text(100),
                'debit' => $debit,
                'credit' => $credit,
            ]);
        }
    }
}
