<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AtisTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AtisTable Test Case
 */
class AtisTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AtisTable
     */
    protected $Atis;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Atis',
        'app.Airports',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Atis') ? [] : ['className' => AtisTable::class];
        $this->Atis = $this->getTableLocator()->get('Atis', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Atis);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AtisTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AtisTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
