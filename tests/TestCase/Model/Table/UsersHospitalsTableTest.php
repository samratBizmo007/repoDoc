<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersHospitalsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersHospitalsTable Test Case
 */
class UsersHospitalsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersHospitalsTable
     */
    public $UsersHospitals;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.users_hospitals',
        'app.users',
        'app.roles',
        'app.employees',
        'app.hospitals'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UsersHospitals') ? [] : ['className' => 'App\Model\Table\UsersHospitalsTable'];
        $this->UsersHospitals = TableRegistry::get('UsersHospitals', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UsersHospitals);

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
