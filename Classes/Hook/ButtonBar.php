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
use TYPO3\CMS\Backend\Template\Components\ButtonBar as T3ButtonBar;
use TYPO3\CMS\Backend\Template\Components\Buttons\ButtonInterface;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Extends header toolbar in page layout view.
 *
 * @author Chetan Thapliyal <chetan.thapliyal@aoe.com>
 */
class ButtonBar
{
    const MODULE_PAGE_LAYOUT = 'web_layout';
    const FUNCTION_PAGE_LAYOUT_COLUMNS = '1';
    const BUTTON_GROUP_DEVICE_CONTENT_FILTER = 80;

    /**
     * Current page-id.
     *
     * @var int
     */
    private $id;

    /**
     * Current module.
     *
     * @var string
     */
    private $moduleName;

    /**
     * Module function.
     *
     * @var string
     */
    private $moduleFunction;

    /**
     * @var T3ButtonBar
     */
    private $buttonBar;

    /**
     * @var IconFactory
     */
    private $iconFactory;


    /**
     * Renders document header buttons to filter content by device type.
     *
     * @param  array $params            Hook parameters.
     * @param  T3ButtonBar $buttonBar   Button bar containing the existing document header buttons.
     * @return array
     */
    public function getButtons(array $params, T3ButtonBar $buttonBar): array
    {
        $this->buttonBar = $buttonBar;
        $buttons = $params['buttons'];
        $this->init();

        // Render new toolbar buttons for "Columns" view in page layout module
        if ($this->id && ($this->moduleName === self::MODULE_PAGE_LAYOUT) && ($this->moduleFunction === self::FUNCTION_PAGE_LAYOUT_COLUMNS)) {
            if (isset($_GET['tx_aoeadaptive_device']) && is_numeric($_GET['tx_aoeadaptive_device'])) {
                $deviceType = intval($_GET['tx_aoeadaptive_device']);
            } else {
                $deviceType = '';
            }

            $buttons[T3ButtonBar::BUTTON_POSITION_LEFT][self::BUTTON_GROUP_DEVICE_CONTENT_FILTER] = [
                $this->getButton(
                    'tx-aoeadaptive-mobile',
                    'Mobile Content',
                    ['tx_aoeadaptive_device' => DeviceDetector::TYPE_MOBILE],
                    (DeviceDetector::TYPE_MOBILE === $deviceType)
                ),
                $this->getButton(
                    'tx-aoeadaptive-pc',
                    'PC/Tablet Content',
                    ['tx_aoeadaptive_device' => DeviceDetector::TYPE_PC_TABLET],
                    (DeviceDetector::TYPE_PC_TABLET === $deviceType)
                ),
                $this->getButton('tx-aoeadaptive-all', 'All Content', [], ('' === $deviceType))
            ];
        }

        return $buttons;
    }

    /**
     * Initializes context variables.
     *
     * @return void
     */
    protected function init()
    {
        $this->id = isset($_GET['id']) ? intval(GeneralUtility::_GET('id')) : 0;
        $this->moduleName = isset($_GET['M']) ? GeneralUtility::_GET('M') : '';

        // TODO: Need better way to get the current context
        if (isset($GLOBALS['SOBE']) && isset($GLOBALS['SOBE']->MOD_SETTINGS['function'])) {
            $this->moduleFunction = $GLOBALS['SOBE']->MOD_SETTINGS['function'];
        } else {
            $this->moduleFunction = '';
        }
    }

    /**
     * @param  string $iconId           Button Icon identifier.
     * @param  string $title            Button link title.
     * @param  array $urlParameters     Additional parameters for button link.
     * @param  bool  $isActive          Flag to set the button as active.
     * @return ButtonInterface
     */
    private function getButton($iconId, $title, array $urlParameters = [], $isActive = false): ButtonInterface
    {
        $urlParameters['id'] = $this->id;

        if ($isActive) {
            $iconId .= '-active';
        }

        return $this->buttonBar->makeLinkButton()
            ->setTitle($title)
            ->setClasses($iconId)
            ->setIcon($this->getIconFactory()->getIcon($iconId, Icon::SIZE_SMALL))
            ->setHref(BackendUtility::getModuleUrl($this->moduleName, $urlParameters));
    }

    /**
     * @return IconFactory
     */
    protected function getIconFactory(): IconFactory
    {
        if (!($this->iconFactory instanceof IconFactory)) {
            $this->iconFactory = GeneralUtility::makeInstance(IconFactory::class);
        }

        return $this->iconFactory;
    }
}
