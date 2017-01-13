<?php

defined('TYPO3_MODE') or die();

$extKey = 'aoe_adaptive';

// Hook to filter frontend content by device type
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_page.php']['addEnableColumns'][$extKey] = 'Aoe\\AoeAdaptive\\Hook\\PageRepository->addEnableColumns';

// Register auth service to add pseudo groups to frontend users
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService($extKey, 'auth', \Aoe\AoeAdaptive\Service\Auth\UserGroup::class, [
    'title' => '',
    'description' => '',
    'subtype' => 'getGroupsFE',
    'available' => true,
    'priority' => 40,
    'quality' => 70,
    'os' => '',
    'exec' => '',
    'className' => \Aoe\AoeAdaptive\Service\Auth\UserGroup::class
]);

// Register backend icons
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon(
    'tx-aoeadaptive-pc',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:' . $extKey . '/Resources/Public/Icons/pc.svg']
);
$iconRegistry->registerIcon(
    'tx-aoeadaptive-pc-active',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:' . $extKey . '/Resources/Public/Icons/pc-active.svg']
);
$iconRegistry->registerIcon(
    'tx-aoeadaptive-mobile',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:' . $extKey . '/Resources/Public/Icons/mobile.svg']
);
$iconRegistry->registerIcon(
    'tx-aoeadaptive-mobile-active',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:' . $extKey . '/Resources/Public/Icons/mobile-active.svg']
);
