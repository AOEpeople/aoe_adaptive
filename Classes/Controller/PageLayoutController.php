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
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Backend\Controller\PageLayoutController as T3PageLayoutController;
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Extends header toolbar in page layout view.
 *
 * @author Chetan Thapliyal <chetan.thapliyal@aoe.com>
 */
class PageLayoutController extends T3PageLayoutController
{
    /**
     * Generates toolbar buttons for page layout view.
     *
     * @param  string $function      Identifier for function of module
     * @return void
     */
    protected function makeButtons($function = '')
    {
        parent::makeButtons($function);

        // Render new toolbar buttons only in "Columns" view
        if ($function === '') {
            $mobileIcon = 'tx-aoeadaptive-mobile';
            $pcIcon = 'tx-aoeadaptive-pc';

            if (isset($_GET['device'])) {
                if (DeviceDetector::TYPE_MOBILE === intval(GeneralUtility::_GET('device'))) {
                    $mobileIcon .= '-active';
                } elseif (DeviceDetector::TYPE_PC_TABLET === intval(GeneralUtility::_GET('device'))) {
                    $pcIcon .= '-active';
                }
            }

            $mobileViewButton = $this->buttonBar->makeLinkButton()
                ->setTitle('Mobile')
                ->setClasses($mobileIcon)
                ->setIcon($this->iconFactory->getIcon($mobileIcon, Icon::SIZE_SMALL))
                ->setHref(BackendUtility::getModuleUrl($this->moduleName, ['id' => $this->id, 'device' => '1']));
            $pcViewButton = $this->buttonBar->makeLinkButton()
                ->setTitle('PC/Tablet')
                ->setClasses($pcIcon)
                ->setIcon($this->iconFactory->getIcon($pcIcon, Icon::SIZE_SMALL))
                ->setHref(BackendUtility::getModuleUrl($this->moduleName, ['id' => $this->id, 'device' => '2']));

            $this->buttonBar->addButton($mobileViewButton, ButtonBar::BUTTON_POSITION_LEFT, 6);
            $this->buttonBar->addButton($pcViewButton, ButtonBar::BUTTON_POSITION_LEFT, 6);
        }
    }
}
