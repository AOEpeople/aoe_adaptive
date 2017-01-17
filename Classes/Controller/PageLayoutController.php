<?php
namespace Aoe\AoeAdaptive\Controller;

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
use TYPO3\CMS\Backend\Controller\PageLayoutController as T3PageLayoutController;
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Backend\Template\Components\Buttons\ButtonInterface;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Extends header toolbar in page layout view.
 *
 * @author Chetan Thapliyal <chetan.thapliyal@aoe.com>
 */
class PageLayoutController extends T3PageLayoutController {
    /**
     * Generates toolbar buttons for page layout view.
     *
     * @param  string $function Identifier for function of module
     * @return void
     */
    protected function makeButtons($function = '') {
        parent::makeButtons($function);

        // Render new toolbar buttons only in "Columns" view
        if ($function === '') {
            $allDesktop = 'tx-aoeadaptive-all';
            $mobileIcon = 'tx-aoeadaptive-mobile';
            $pcIcon = 'tx-aoeadaptive-pc';

            if (isset($_GET['tx_aoeadaptive_device']) && is_numeric($_GET['tx_aoeadaptive_device'])) {
                $deviceType = intval(GeneralUtility::_GET('tx_aoeadaptive_device'));

                if (DeviceDetector::TYPE_MOBILE === $deviceType) {
                    $mobileIcon .= '-active';
                } elseif (DeviceDetector::TYPE_PC_TABLET === $deviceType) {
                    $pcIcon .= '-active';
                }
            } else {
                $allDesktop .= '-active';
            }

            $this->buttonBar->addButton(
                $this->getButton($mobileIcon, 'Mobile Content', ['tx_aoeadaptive_device' => DeviceDetector::TYPE_MOBILE]),
                ButtonBar::BUTTON_POSITION_LEFT, 6
            );
            $this->buttonBar->addButton(
                $this->getButton($pcIcon, 'PC/Tablet Content', ['tx_aoeadaptive_device' => DeviceDetector::TYPE_PC_TABLET]),
                ButtonBar::BUTTON_POSITION_LEFT, 6
            );
            $this->buttonBar->addButton(
                $this->getButton($allDesktop, 'All Content'),
                ButtonBar::BUTTON_POSITION_LEFT, 6
            );
        }
    }

    /**
     * @param  string $iconId Button Icon identifier.
     * @param  string $title Button link title.
     * @param  array $urlParameters Additional parameters for button link.
     * @return ButtonInterface
     */
    private function getButton($iconId, $title, array $urlParameters = []): ButtonInterface {
        $urlParameters['id'] = $this->id;

        return $this->buttonBar->makeLinkButton()
            ->setTitle($title)
            ->setClasses($iconId)
            ->setIcon($this->iconFactory->getIcon($iconId, Icon::SIZE_SMALL))
            ->setHref(BackendUtility::getModuleUrl($this->moduleName, $urlParameters));
    }
}
