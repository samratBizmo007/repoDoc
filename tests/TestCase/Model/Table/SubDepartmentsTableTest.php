<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SubDepartmentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SubDepartmentsTable Test Case
 */
class SubDepartmentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SubDepartmentsTable
     */
    public $SubDepartments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.sub_departments',
        'app.departments',
        'app.followups',
        'app.signout_notes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('SubDepartments') ? [] : ['className' => 'App\Model\Table\SubDepartmentsTable'];
        $this->SubDepartments = TableRegistry::get('SubDepartments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SubDepartments);

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
