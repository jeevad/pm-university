<?php

use Illuminate\Database\Seeder;
use App\Models\ContentTag;
use Illuminate\Database\QueryException;

class ContentTagsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::selectSheets('ContentTagging')->load(database_path('seeds/seed_files/product-management.xlsx'),
            function ($reader) {
            // Getting all results
            $results = $reader->get();

            // Truncate channels
            DB::table('content_tag')->truncate();
            $i = 0;
            foreach ($results as $row) {
                try {
                    ContentTag::create([
                        'content_id' => $row->content_id,
                        'tag_id' => $row->tag_id
                    ]);
                } catch (QueryException $e) {
                    die('Some exception occured. <br/>'.$e->getMessage());
                }
                $i++;
            }
            echo $i.' Content Tagging successfully inserted'.PHP_EOL;
        });
    }
}