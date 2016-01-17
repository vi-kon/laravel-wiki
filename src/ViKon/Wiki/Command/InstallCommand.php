<?php

namespace ViKon\Wiki\Command;

use Illuminate\Console\Command;
use ViKon\Auth\Model\User;

/**
 * Class InstallCommand
 *
 * @package ViKon\Wiki\Command
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
class InstallCommand extends Command
{
    /**
     * InstallCommand constructor.
     */
    public function __construct()
    {
        $this->signature   = 'vi-kon:wiki:install';
        $this->description = 'Install Wiki engine';

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dbConfig = config_db();

        if ($dbConfig->get('wiki:installed', false)) {
            $this->line('Wiki is already installed');

            return;
        }

        $this->line('Creating <info>system</info> user... ');

        // Create system user
        $systemUser           = new User();
        $systemUser->username = 'system';
        $systemUser->password = '';
        $systemUser->hidden   = true;
        $systemUser->static   = true;
        $systemUser->blocked  = true;
        $systemUser->save();

        // --------------------------------------------------------------------

        $this->line('Creating config entries... ');

        $dbConfig->set('wiki::title', 'Wiki name', $systemUser, true);

        // Note this entry have to be at last position to ensure that wiki is installed
        $dbConfig->set('wiki::installed', true, $systemUser, true);

        $this->line('Wiki successfully installed');
    }
}