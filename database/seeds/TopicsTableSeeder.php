<?php

use App\Models\Topic;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;

class TopicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::selectSheets('topics')->load(database_path('seeds/seed_files/product-management.xlsx'), function ($reader) {
            // Getting all results
            $results = $reader->get();

            // Truncate topics
            Topic::truncate();
            $i = 0;
            foreach ($results as $row) {
                try {
                    Topic::create([
                        'title'    => ucwords(strtolower($row->title)),
                        'level_id' => (int) $row->level_id,
                        'user_id'  => (int) $row->created_by,
                        'slug'     => str_slug($row->title, '-'),
                    ]);
                } catch (QueryException $e) {
                    die('Some exception occured. <br/>'.$e->getMessage());
                }
                $i++;
            }
            echo $i.' Topics successfully inserted'.PHP_EOL;
        });
    }
}
