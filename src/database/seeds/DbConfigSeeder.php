<?php

use ViKon\DbConfig\Models\Config;
use ViKon\Utilities\Seeder;

/**
 * Class DbConfigSeeder
 *
 * @author Kovács Vince <vincekovacs@hotmail.com>
 *
 */
class DbConfigSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->startTable('config');

        $config = [
            'title' => ['wiki', 'string', 'Wiki name'],
        ];

        $this->setMaxEntryCount(count($config));

        foreach ($config as $key => $value) {
            Config::create([
                'key'   => $key,
                'group' => $value[0],
                'type'  => $value[1],
                'value' => $value[2],
            ]);

            $this->incProcessedEntryCount();
        }
    }
}