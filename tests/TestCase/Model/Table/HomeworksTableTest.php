<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\HomeworksTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\HomeworksTable Test Case
 */
class HomeworksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\HomeworksTable
     */
    protected $Homeworks;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Homeworks',
        'app.Users',
        'app.Papers',
        'app.Comments',
        'app.Slides',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Homeworks') ? [] : ['className' => HomeworksTable::class];
        $this->Homeworks = $this->getTableLocator()->get('Homeworks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Homeworks);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\HomeworksTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\HomeworksTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
