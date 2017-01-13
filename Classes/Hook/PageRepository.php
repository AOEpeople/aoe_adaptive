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
use TYPO3\CMS\Frontend\Page\PageRepository as T3PageRepository;

/**
 * @package Aoe\AoeAdaptive\Hook
 */
class PageRepository
{
    /**
     * @var DeviceDetector
     */
    private $userAgentDetector;

    /**
     * @param  array $params                Hook parameters.
     * @param  T3PageRepository $parent     Parent class calling the hook.
     * @return string
     */
    public function addEnableColumns(array $params, T3PageRepository $parent)
    {
        $contentSelectionCriteria = '';
        $userAgentDetector = $this->getUserAgentDetector();

        if ($params['table'] === 'tt_content') {
            if ($userAgentDetector && $userAgentDetector->isMobile()) {
                $contentSelectionCriteria = '(' .
                    'FIND_IN_SET(\'' . DeviceDetector::TYPE_MOBILE. '\', tx_aoeadaptive_devices) ' .
                    'OR tx_aoeadaptive_devices = ""' .
                ')';
            } else {
                $contentSelectionCriteria = '(' .
                    'FIND_IN_SET(\'' . DeviceDetector::TYPE_PC_TABLE . '\', tx_aoeadaptive_devices) ' .
                    'OR tx_aoeadaptive_devices = ""' .
                ')';
            }
        }

        return $contentSelectionCriteria;
    }

    /**
     * Gets an instance of user agent detector class.
     *
     * @return DeviceDetector
     */
    protected function getUserAgentDetector()
    {
        if (!($this->userAgentDetector instanceof DeviceDetector)) {
            $this->userAgentDetector = GeneralUtility::makeInstance(DeviceDetector::class);
        }

        return $this->userAgentDetector;
    }
}
