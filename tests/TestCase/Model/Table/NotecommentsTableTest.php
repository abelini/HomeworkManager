<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NotecommentsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NotecommentsTable Test Case
 */
class NotecommentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\NotecommentsTable
     */
    protected $Notecomments;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Notecomments',
        'app.Users',
        'app.Papers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Notecomments') ? [] : ['className' => NotecommentsTable::class];
        $this->Notecomments = $this->getTableLocator()->get('Notecomments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Notecomments);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\NotecommentsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\NotecommentsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
