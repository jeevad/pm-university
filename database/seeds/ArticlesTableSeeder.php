<?php
use Illuminate\Database\Seeder;
use App\Models\Article;
use Illuminate\Database\QueryException;
use App\Traits\Sluggable;

class ArticlesTableSeeder extends Seeder
{
    
    use Sluggable;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::selectSheets('articles')->load(database_path('seeds/seed_files/product-management.xlsx'), function ($reader) {
            // Getting all results
            $results = $reader->get();
            
            // Truncate articles if any
            DB::table('articles')->truncate();
            $i = 0;
            foreach ($results as $row) {
                try {
                    $content = new Article();
                    $pageTitle = getTitleViaLink($row->url);
                    Article::create([
                        'topic_id' => $row->topic_id,
                        'user_id' => $row->user_id,
                        'source_url' => $row->url,
                        'title' => $pageTitle,
                        'slug' => $this->generateSlug($content, $pageTitle)
                    ]);
                } catch (QueryException $e) {
                    die('Some exception occured. <br/>' . $e->getMessage());
                } catch (\ErrorException $e) {
                    die('Some exception occured. <br/>' . $e->getMessage());
                }
                $i ++;
            }
            echo $i . ' Articles successfully inserted' . PHP_EOL;
        });
    }
}