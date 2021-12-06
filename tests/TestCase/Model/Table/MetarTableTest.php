<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MetarTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MetarTable Test Case
 */
class MetarTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MetarTable
     */
    protected $Metar;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Metar',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Metar') ? [] : ['className' => MetarTable::class];
        $this->Metar = $this->getTableLocator()->get('Metar', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Metar);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MetarTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
