<?php

use Illuminate\Database\Seeder;

/**
 * Class WikiSeeder
 *
 * @author Kovács Vince <vincekovacs@hotmail.com>
 *
 */
class WikiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('AuthSeeder');
        $this->call('DbConfigSeeder');
    }
}