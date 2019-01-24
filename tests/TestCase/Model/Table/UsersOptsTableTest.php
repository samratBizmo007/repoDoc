<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersOptsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersOptsTable Test Case
 */
class UsersOptsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersOptsTable
     */
    public $UsersOpts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.users_opts'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UsersOpts') ? [] : ['className' => 'App\Model\Table\UsersOptsTable'];
        $this->UsersOpts = TableRegistry::get('UsersOpts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UsersOpts);

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
