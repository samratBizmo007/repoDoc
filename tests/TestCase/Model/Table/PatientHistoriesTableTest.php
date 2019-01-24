<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PatientHistoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PatientHistoriesTable Test Case
 */
class PatientHistoriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PatientHistoriesTable
     */
    public $PatientHistories;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.patient_histories',
        'app.patients',
        'app.hospitals',
        'app.hospitals_employees',
        'app.employees',
        'app.roles',
        'app.users',
        'app.users_hospitals',
        'app.diagnoses',
        'app.followups',
        'app.departments',
        'app.signout_notes',
        'app.major_events',
        'app.reminders',
        'app.voice_notes',
        'app.employees_schedules',
        'app.employees_patients',
        'app.service_teams',
        'app.patient_service_teams'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('PatientHistories') ? [] : ['className' => 'App\Model\Table\PatientHistoriesTable'];
        $this->PatientHistories = TableRegistry::get('PatientHistories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PatientHistories);

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
