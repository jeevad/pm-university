<?php

use Illuminate\Database\Seeder;
use App\Models\Level;
use Illuminate\Database\QueryException;

class LevelsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::selectSheets('Levels')->load(database_path('seeds/seed_files/product-management.xlsx'),
            function ($reader) {
            // Getting all results
            $results = $reader->get();

            // Truncate role
            Level::truncate();
            $i = 0;
            foreach ($results as $row) {
                try {
                    Level::create([
                        'title' => $row->title,
                        'slug' => str_slug($row->title, '-')
                    ]);
                } catch (QueryException $e) {
                    die('Some exception occured. <br/>'.$e->getMessage());
                }
                $i++;
            }
            echo $i.' Levels successfully inserted'.PHP_EOL;
        });
    }
}