<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ItemCategoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ItemCategoriesTable Test Case
 */
class ItemCategoriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ItemCategoriesTable
     */
    public $ItemCategories;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.item_categories',
        'app.item_subcategories',
        'app.items'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ItemCategories') ? [] : ['className' => ItemCategoriesTable::class];
        $this->ItemCategories = TableRegistry::getTableLocator()->get('ItemCategories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ItemCategories);

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
}
