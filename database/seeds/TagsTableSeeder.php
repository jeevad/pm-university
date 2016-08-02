<?php
use Illuminate\Database\Seeder;
use App\Models\Tag;
use Illuminate\Database\QueryException;

class TagsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::selectSheets('Tags')->load(database_path('seeds/seed_files/product-management.xlsx'), function ($reader) {
            // Getting all results
            $results = $reader->get();
            
            // Truncate tags
            Tag::truncate();
            $i = 0;
            foreach ($results as $row) {
                try {
                    Tag::create([
                        'title' => ucwords(strtolower($row->title))
                    ]);
                } catch (QueryException $e) {
                    die('Some exception occured. <br/>' . $e->getMessage());
                }
                $i ++;
            }
            echo $i . ' Tags successfully inserted' . PHP_EOL;
        });
    }
}