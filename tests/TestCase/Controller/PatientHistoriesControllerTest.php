<?php
namespace App\Test\TestCase\Controller;

use App\Controller\PatientHistoriesController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\PatientHistoriesController Test Case
 */
class PatientHistoriesControllerTest extends IntegrationTestCase
{

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
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
