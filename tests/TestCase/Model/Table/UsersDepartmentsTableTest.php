<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersDepartmentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersDepartmentsTable Test Case
 */
class UsersDepartmentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersDepartmentsTable
     */
    public $UsersDepartments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.users_departments',
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
        'app.users_hospitals'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UsersDepartments') ? [] : ['className' => 'App\Model\Table\UsersDepartmentsTable'];
        $this->UsersDepartments = TableRegistry::get('UsersDepartments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UsersDepartments);

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
