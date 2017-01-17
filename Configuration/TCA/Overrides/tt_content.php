<?php

defined('TYPO3_MODE') or die();

use Aoe\AoeAdaptive\Service;

$langFile = 'LLL:EXT:aoe_adaptive/Resources/Private/Language/Backend/Tceform.xlf';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'tt_content',
    [
        'tx_aoeadaptive_devices' => [
            'exclude' => 1,
            'label' => $langFile . ':tt_content.tx_aoeadaptive_devices',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'showIconTable' => true,
                'items' => [
                    [$langFile . ':tt_content.tx_aoeadaptive_devices.mobile', Service\DeviceDetector::TYPE_MOBILE],
                    [$langFile . ':tt_content.tx_aoeadaptive_devices.tablet_pc', Service\DeviceDetector::TYPE_PC_TABLET],
                ],
                'size' => 2,
                'maxitems' => 1
            ]
        ]
    ]
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;' . $langFile . ':tabs.devices,tx_aoeadaptive_devices'
);
