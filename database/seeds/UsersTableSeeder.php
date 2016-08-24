<?php

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::selectSheets('Users')->load(database_path('seeds/seed_files/product-management.xlsx'), function ($reader) {
            // Getting all results
            $results = $reader->get();

            // Truncate users
            User::truncate();
            $i = 0;
            foreach ($results as $row) {
                try {
                    User::create([
                        'api_token' => generateGUID(),
                        'email'     => strtolower($row->email),
                        'password'  => bcrypt($row->password),
                        'role_id'   => (int) $row->role_id,
                        'full_name' => ucwords(strtolower($row->full_name)),
                        'activated' => true,
                        'slug'      => str_slug(ucwords(strtolower($row->full_name)), '-'),
                    ]);
                } catch (QueryException $e) {
                    die('Some exception occured. <br/>'.$e->getMessage());
                }
                $i++;
            }
            echo $i.' Users successfully inserted'.PHP_EOL;
        });
    }
}
