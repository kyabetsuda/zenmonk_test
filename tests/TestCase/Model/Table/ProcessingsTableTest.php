<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProcessingsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProcessingsTable Test Case
 */
class ProcessingsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProcessingsTable
     */
    public $Processings;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.processings'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Processings') ? [] : ['className' => ProcessingsTable::class];
        $this->Processings = TableRegistry::getTableLocator()->get('Processings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Processings);

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
