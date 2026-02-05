<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PapersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PapersTable Test Case
 */
class PapersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PapersTable
     */
    protected $Papers;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Papers',
        'app.Groups',
        'app.Homeworks',
        'app.Notecomments',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Papers') ? [] : ['className' => PapersTable::class];
        $this->Papers = $this->getTableLocator()->get('Papers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Papers);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PapersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\PapersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
