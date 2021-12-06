<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AirportsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AirportsTable Test Case
 */
class AirportsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AirportsTable
     */
    protected $Airports;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
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
        $config = $this->getTableLocator()->exists('Airports') ? [] : ['className' => AirportsTable::class];
        $this->Airports = $this->getTableLocator()->get('Airports', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Airports);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AirportsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
