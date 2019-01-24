<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmployeeRolesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmployeeRolesTable Test Case
 */
class EmployeeRolesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EmployeeRolesTable
     */
    public $EmployeeRoles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.employee_roles'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('EmployeeRoles') ? [] : ['className' => 'App\Model\Table\EmployeeRolesTable'];
        $this->EmployeeRoles = TableRegistry::get('EmployeeRoles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmployeeRoles);

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
