<?php
namespace Aoe\AoeAdaptive\Hook;

/*
 * (c) 2016 AOE GmbH <dev@aoe.com>
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
 * Implements hooks in PageRepository class.
 *
 * @author Chetan Thapliyal <chetan.thapliyal@aoe.com>
 */
class PageRepository
{
    /**
     * Generates SQL condition to filter content by client's device type.
     *
     * @param  array $params        Hook parameters.
     * @return string
     */
    public function addEnableColumns(array $params)
    {
        $contentSelectionCriteria = '';

        if ($params['table'] === 'tt_content') {
            $deviceDetector = GeneralUtility::makeInstance(DeviceDetector::class);
            $deviceType = ($deviceDetector && $deviceDetector->isMobile())
                          ? DeviceDetector::TYPE_MOBILE
                          : DeviceDetector::TYPE_PC_TABLET;
            $contentSelectionCriteria = "(FIND_IN_SET('$deviceType', tx_aoeadaptive_devices) OR tx_aoeadaptive_devices = '')";
        }

        return $contentSelectionCriteria;
    }
}
