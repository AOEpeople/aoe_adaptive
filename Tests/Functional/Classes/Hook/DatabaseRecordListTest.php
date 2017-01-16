<?php
namespace Aoe\AoeAdaptive\Hook;

/*
 * (c) 2017 AOE GmbH <dev@aoe.com>
 * All rights reserved
 *
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use Aoe\AoeAdaptive\Service\DeviceDetector;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Tests\FunctionalTestCase;
use TYPO3\CMS\Recordlist\RecordList\DatabaseRecordList;

/**
 * @author Chetan Thapliyal <chetan.thapliyal@aoe.com>
 */
class DatabaseRecordListTest extends FunctionalTestCase
{
    /**
     * Set up framework
     *
     * @return void
     */
    public function setUp() {
        // always call setUp after setting the required test extension
        $this->testExtensionsToLoad[] = 'typo3conf/ext/aoe_adaptive';

        parent::setUp();
    }

    /**
     * Checks that query builder in DatabaseRecordList class generates correct content filter for different device types.
     *
     * @test
     * @dataProvider deviceTypeDataProvider
     *
     * @param string $deviceType    Device Type e.g. PC, Mobile. See DeviceDetector::TYPE_XXX constants.
     */
    public function queryBuilderContainsDeviceTypeFilter(string $deviceType)
    {
        $_GET['tx_aoeadaptive_device'] = $deviceType;
        $databaseRecordList = new DatabaseRecordList();

        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $databaseRecordList->getQueryBuilder('tt_content', 999999);
        $this->assertContains(
            "((FIND_IN_SET('$deviceType', tx_aoeadaptive_devices) OR tx_aoeadaptive_devices = ''))",
            $queryBuilder->getSQL()
        );
    }

    /**
     * Checks that query builder in DatabaseRecordList class does not generate content filter for invalid device types.
     *
     * @test
     * @dataProvider invalidDeviceTypeDataProvider
     *
     * @param mixed $deviceType    Invalid Device Types.
     */
    public function queryBuilderDoesNotContainDeviceTypeFilter($deviceType)
    {
        if (!is_null($deviceType)) {
            $_GET['tx_aoeadaptive_device'] = $deviceType;
        }

        $databaseRecordList = new DatabaseRecordList();

        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $databaseRecordList->getQueryBuilder('tt_content', 999999);
        $this->assertNotContains('tx_aoeadaptive_devices', $queryBuilder->getSQL());
    }

    /**
     * Provides valid device types.
     *
     * @return array
     */
    public function deviceTypeDataProvider()
    {
        return [
            [DeviceDetector::TYPE_MOBILE],
            [DeviceDetector::TYPE_PC_TABLET],
        ];
    }

    /**
     * Provides invalid device types.
     *
     * @return array
     */
    public function invalidDeviceTypeDataProvider()
    {
        return [
            [null],
            [''],
            ['1484583827'],
        ];
    }
}
