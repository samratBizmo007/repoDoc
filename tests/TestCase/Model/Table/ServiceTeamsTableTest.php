<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ServiceTeamsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ServiceTeamsTable Test Case
 */
class ServiceTeamsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ServiceTeamsTable
     */
    public $ServiceTeams;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.service_teams',
        'app.hospitals',
        'app.hospital_employees',
        'app.patients'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ServiceTeams') ? [] : ['className' => 'App\Model\Table\ServiceTeamsTable'];
        $this->ServiceTeams = TableRegistry::get('ServiceTeams', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ServiceTeams);

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
