<?php

defined('TYPO3_MODE') or die();

$extKey = 'aoe_adaptive';

// Define labels to display in context sensitive help for extended fields
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
    'tt_content', 'EXT:' . $extKey . '/Resources/Private/Language/Backend/Tceform.xlf'
);

// Register extended root-line utility class
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\CMS\Backend\Controller\PageLayoutController']['className'] = 'Aoe\\AoeAdaptive\\Controller\\PageLayoutController';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['TYPO3\CMS\Recordlist\RecordList\DatabaseRecordList']['buildQueryParameters'][$extKey] = 'Aoe\\AoeAdaptive\\Hook\\DatabaseRecordList';


// Register backend styles
$GLOBALS['TBE_STYLES']['skins'][$extKey]['stylesheetDirectories']['commonCss'] = 'EXT:aoe_adaptive/Resources/Public/Css/Backend/';
