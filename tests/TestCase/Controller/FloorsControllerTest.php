<?php
namespace App\Test\TestCase\Controller;

use App\Controller\FloorsController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\FloorsController Test Case
 */
class FloorsControllerTest extends IntegrationTestCase
{

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
