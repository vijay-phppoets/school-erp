<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GrnsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GrnsTable Test Case
 */
class GrnsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\GrnsTable
     */
    public $Grns;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.grns',
        'app.vendors',
        'app.session_years',
        'app.purchase_orders',
        'app.grn_rows',
        'app.purchase_returns'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Grns') ? [] : ['className' => GrnsTable::class];
        $this->Grns = TableRegistry::getTableLocator()->get('Grns', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Grns);

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
