<?php
namespace Aoe\AoeAdaptive\Hook;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 Deniz Dagtekin <deniz.dagtekin@aoe.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 *
 * @author Deniz Dagtekin
 ***************************************************************/

use Aoe\AoeAdaptive\Service\DeviceDetector;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Utility\GeneralUtility;


/**
 * Show device type in the tt_content draw header.
 *
 * @author Deniz Dagtekin <deniz.dagtekin@aoe.com>
 *
 */
class PageLayoutViewDrawHeader
{

    /**
     * Draw the header for a single tt_content element
     *
     * @param $params
     * @param $parentObject
     * @return mixed
     */
    public function tt_content_drawHeader($params, $parentObject)
    {
        if ($params[0] === 'tt_content') {
            if ($params['2']['tx_aoeadaptive_devices'] == DeviceDetector::TYPE_MOBILE) {
                $icon = 'tx-aoeadaptive-mobile';
            } elseif ($params['2']['tx_aoeadaptive_devices'] == DeviceDetector::TYPE_PC_TABLET) {
                $icon = 'tx-aoeadaptive-pc';
            } else {
                $icon = 'tx-aoeadaptive-all';
            }

            $iconFactory = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconFactory::class);
            return $iconFactory->getIcon($icon, Icon::SIZE_SMALL)->render();
        }
    }
}