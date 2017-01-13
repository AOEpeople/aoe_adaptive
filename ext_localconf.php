<?php

defined('TYPO3_MODE') or die('');

$extKey = 'aoe_adaptive';

if (TYPO3_MODE == 'BE') {
#    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem'][$extKey] = 'Aoe\\AoeResponsive\\Hooks\\PageLayoutViewDrawItem';
}

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_page.php']['addEnableColumns'][$extKey] = 'Aoe\\AoeAdaptive\\Hook\\PageRepository->addEnableColumns';


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
