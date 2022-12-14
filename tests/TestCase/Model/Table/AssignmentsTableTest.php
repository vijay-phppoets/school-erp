<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AssignmentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AssignmentsTable Test Case
 */
class AssignmentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AssignmentsTable
     */
    public $Assignments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.assignments',
        'app.session_years',
        'app.media',
        'app.student_classes',
        'app.streams',
        'app.sections',
        'app.subjects',
        'app.assignment_students'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Assignments') ? [] : ['className' => AssignmentsTable::class];
        $this->Assignments = TableRegistry::getTableLocator()->get('Assignments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Assignments);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
