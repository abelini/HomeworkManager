<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'password' => '',
                'group_id' => 1,
                'nombres' => 'Lorem ipsum dolor sit amet',
                'apellidos' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'photo' => 'Lorem ipsum dolor sit amet',
                'admin' => 1,
                'online' => 1,
                'created' => '2022-11-17 19:01:47',
                'modified' => '2022-11-17 19:01:47',
                'pr' => 1,
                'register_ip' => 'Lorem ipsum d',
                'access_ip' => 'Lorem ipsum d',
                'starred' => 1,
            ],
        ];
        parent::init();
    }
}
