<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RawFeedsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RawFeedsTable Test Case
 */
class RawFeedsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RawFeedsTable
     */
    protected $RawFeeds;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.RawFeeds',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('RawFeeds') ? [] : ['className' => RawFeedsTable::class];
        $this->RawFeeds = $this->getTableLocator()->get('RawFeeds', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->RawFeeds);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
