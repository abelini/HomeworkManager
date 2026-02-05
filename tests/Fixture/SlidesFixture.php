<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SlidesFixture
 */
class SlidesFixture extends TestFixture
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
                'homework_id' => 1,
                'file' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
