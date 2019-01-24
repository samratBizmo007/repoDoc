<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FloorsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FloorsTable Test Case
 */
class FloorsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FloorsTable
     */
    public $Floors;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.floors',
        'app.hospitals',
        'app.hospitals_employees',
        'app.employees',
        'app.roles',
        'app.users',
        'app.users_hospitals',
        'app.users_departments',
        'app.departments',
        'app.followups',
        'app.patients',
        'app.service_teams',
        'app.major_events',
        'app.reminders',
        'app.signout_notes',
        'app.voice_notes',
        'app.patient_service_teams',
        'app.diagnoses',
        'app.employees_schedules',
        'app.employees_patients'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Floors') ? [] : ['className' => 'App\Model\Table\FloorsTable'];
        $this->Floors = TableRegistry::get('Floors', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Floors);

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
