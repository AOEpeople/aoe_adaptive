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
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Extends `DatabaseRecordList` core class to filter content elements in page module by device type.
 *
 * @author Chetan Thapliyal <chetan.thapliyal@aoe.com>
 */
class DatabaseRecordList
{
    /**
     * Generates SQL condition to filter content by device type.
     *
     * @param  array  $parameters   Hook parameters
     * @param  string $table        Table name
     * @return void
     */
    public function buildQueryParametersPostProcess(&$parameters, $table)
    {
        if (($table === 'tt_content') && (isset($_GET['device']))) {
            $deviceType = (DeviceDetector::TYPE_MOBILE === intval(GeneralUtility::_GP('device')))
                          ? DeviceDetector::TYPE_MOBILE
                          : DeviceDetector::TYPE_PC_TABLET;
            $parameters['where'][] = "(FIND_IN_SET('$deviceType', tx_aoeadaptive_devices) OR tx_aoeadaptive_devices = '')";
        }
    }
}
