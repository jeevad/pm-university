<?php
use Illuminate\Database\Seeder;
use App\Models\Channel;
use Illuminate\Database\QueryException;

class ChannelsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::selectSheets('Channels')->load(database_path('seeds/seed_files/product-management.xlsx'), function ($reader) {
            // Getting all results
            $results = $reader->get();
            
            // Truncate channels
            DB::table('channels')->truncate();
            $i = 0;
            foreach ($results as $row) {
                try {
                    Channel::create([
                        'title' => $row->title,
                        'slug' => str_slug($row->title, '-')
                    ]);
                } catch (QueryException $e) {
                    die('Some exception occured. <br/>' . $e->getMessage());
                }
                $i ++;
            }
            echo $i . ' Channels successfully inserted' . PHP_EOL;
        });
    }
}