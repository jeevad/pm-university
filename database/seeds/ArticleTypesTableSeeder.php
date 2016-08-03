<?php
use Illuminate\Database\Seeder;
use App\Models\ArticleType;
use Illuminate\Database\QueryException;

class ArticleTypesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::selectSheets('article_types')->load(database_path('seeds/seed_files/product-management.xlsx'), function ($reader) {
            // Getting all results
            $results = $reader->get();
            
            // Truncate types
            ArticleType::truncate();
            $i = 0;
            foreach ($results as $row) {
                try {
                    ArticleType::create([
                        'title' => ucwords(strtolower($row->title))
                    ]);
                } catch (QueryException $e) {
                    die('Some exception occured. <br/>' . $e->getMessage());
                }
                $i ++;
            }
            echo $i . ' Article types successfully inserted' . PHP_EOL;
        });
    }
}