<?php

use Illuminate\Database\Seeder;
use ViKon\DbConfig\Models\Config;
use ViKon\Utilities\SeederProgressBarTrait;

/**
 * Class DbConfigSeeder
 *
 * @author Kovács Vince <vincekovacs@hotmail.com>
 *
 */
class DbConfigSeeder extends Seeder {
    use SeederProgressBarTrait;

    protected $output;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $progress = $this->createProgressBar();

        $config = [
            'title' => ['wiki', 'string', 'Wiki name'],
        ];

        $progress->start(count($config));

        foreach ($config as $key => $value) {
            list($group, $type, $value) = $value;
            Config::create([
                'key'   => $key,
                'group' => $group,
                'type'  => $type,
                'value' => $value,
            ]);
            /** @noinspection DisconnectedForeachInstructionInspection */
            $progress->advance();
        }

        $progress->finish();
        $this->command->getOutput()->writeln('');
    }
}