<?php
use ViKon\Utilities\Seeder;


/**
 * Class AuthSeeder
 *
 * @author Kovács Vince <vincekovacs@hotmail.com>
 *
 */
class AuthSeeder extends Seeder {
    use \ViKon\Auth\AuthSeeder;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $roles = $this->createRoles();
        $this->createUsers($roles);
    }

    public function createUsers($roles) {
        $this->startTable('users');

        $users = [
            'admin' => [null, true, true],
            'test'  => [null, false, false],
//            'username'    => ['home route name', 'is static', 'is hidden'],
        ];

        $this->setMaxEntryCount(count($users));
        foreach ($users as $username => &$options) {
            $options = $this->createUser($username, $username, $username . '@wiki.hu', $options[0], $options[1], $options[2]);

            $options->roles()
                ->saveMany($roles);
        }

        return $users;
    }

    private function createRoles() {
        $this->startTable('user_roles');

        $roles = [
            'admin.index'         => 'Show administration panel',

            'admin.user.index'    => 'Show users table on administration panel',
            'admin.user.show'     => 'Show individual user on administration panel',
            'admin.user.create'   => 'Create new user on administration panel',
            'admin.user.edit'     => 'Edit individual user on administration panel',
            'admin.user.destroy'  => 'Destroy individual user on administration panel',

            'admin.role.index'    => 'Show roles table on administration panel',

            'admin.group.index'   => 'Show user groups table on administration panel',
            'admin.group.show'    => 'Show individual user group on administration panel',
            'admin.group.create'  => 'Create new user group on administration panel',
            'admin.group.edit'    => 'Edit individual user group on administration panel',
            'admin.group.destroy' => 'Destroy individual user group on administration panel',

            'wiki.show'           => 'Show Wiki page',
            'wiki.create'         => 'Create a Wiki page',
            'wiki.edit'           => 'Edit Wiki page',
            'wiki.move'           => 'Move wiki to another URL',
            'wiki.destroy'        => 'Destroy Wiki page',
        ];

        $this->setMaxEntryCount(count($roles));
        foreach ($roles as $name => &$description) {
            $description = $this->createRole($name, $description);
        }

        return $roles;
    }
}