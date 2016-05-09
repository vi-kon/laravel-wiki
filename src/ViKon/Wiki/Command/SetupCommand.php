<?php

namespace ViKon\Wiki\Command;

use Illuminate\Console\Command;
use ViKon\Auth\Model\User;

/**
 * Class SetupCommand
 *
 * @package ViKon\Wiki\Command
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
class SetupCommand extends Command
{
    /**
     * SetupCommand constructor.
     */
    public function __construct()
    {
        $this->signature   = 'vi-kon:wiki:setup';
        $this->description = 'Setup Wiki engine from beginning';

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('Creating <info>admin</info> user... ');

        $username = $this->ask('Username', 'admin');
        do {
            $password = $this->secret('Password');

            if (strlen($password) < 8) {
                $this->error('Password have to contains least 8 characters');
                continue;
            }

            $passwordConfirmation = $this->secret('Password confirmation');

            if ($password !== $passwordConfirmation) {
                $this->error('Password and Password confirmation do not match');
                continue;
            }
        } while ($password !== $passwordConfirmation && strlen($password) < 8);

        // Create admin user
        $systemUser           = new User();
        $systemUser->username = $username;
        $systemUser->password = $password;
        $systemUser->hidden   = true;
        $systemUser->save();
    }
}