<?php

namespace ViKon\Wiki\Command;

use Illuminate\Console\Command;
use ViKon\Auth\Model\Permission;
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

        $this->line('Creating <info>system user</info>... ');

        // Create system user
        $systemUser           = new User();
        $systemUser->username = 'system';
        $systemUser->password = '';
        $systemUser->hidden   = true;
        $systemUser->static   = true;
        $systemUser->blocked  = true;
        $systemUser->save();

        // --------------------------------------------------------------------

        $this->line('Creating <info>config entries</info>... ');

        $dbConfig->create('wiki::title', 'string', 'Wiki name');

        // Note this entry have to be at last position to ensure that wiki is installed
        $dbConfig->create('wiki::installed', 'bool', true);

        // --------------------------------------------------------------------

        $this->line('Creating <info>system roles</info>...');

        $permissions = [
            'admin.index',

            'admin.user.index',
            'admin.user.show',
            'admin.user.create',
            'admin.user.edit',
            'admin.user.destroy',

            'admin.group.index',
            'admin.group.show',
            'admin.group.create',
            'admin.group.edit',
            'admin.group.destroy',

            'admin.role.index',
            'admin.role.show',
            'admin.role.create',
            'admin.role.edit',
            'admin.role.destroy',

            'admin.permission.index',

            'wiki.show',
            'wiki.create',
            'wiki.edit',
            'wiki.move',
            'wiki.destroy',
        ];

        foreach ($permissions as $token) {
            $permission        = new Permission();
            $permission->token = $token;
            $permission->save();
        }

        $this->line('Wiki successfully installed');
    }
}