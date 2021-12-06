<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ControllersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ControllersTable Test Case
 */
class ControllersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ControllersTable
     */
    protected $Controllers;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Controllers',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Controllers') ? [] : ['className' => ControllersTable::class];
        $this->Controllers = $this->getTableLocator()->get('Controllers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Controllers);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ControllersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ControllersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
