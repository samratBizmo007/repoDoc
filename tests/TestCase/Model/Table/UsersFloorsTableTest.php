<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersFloorsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersFloorsTable Test Case
 */
class UsersFloorsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersFloorsTable
     */
    public $UsersFloors;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.users_floors',
        'app.users',
        'app.roles',
        'app.hospitals',
        'app.hospitals_employees',
        'app.employees',
        'app.diagnoses',
        'app.followups',
        'app.departments',
        'app.signout_notes',
        'app.patients',
        'app.service_teams',
        'app.major_events',
        'app.reminders',
        'app.voice_notes',
        'app.patient_service_teams',
        'app.employees_schedules',
        'app.employees_patients',
        'app.users_hospitals',
        'app.users_departments'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UsersFloors') ? [] : ['className' => 'App\Model\Table\UsersFloorsTable'];
        $this->UsersFloors = TableRegistry::get('UsersFloors', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UsersFloors);

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
