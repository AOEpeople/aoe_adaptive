<?php

defined('TYPO3_MODE') or die('');

$extKey = 'aoe_adaptive';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
    'tt_content', 'EXT:' . $extKey . '/Resources/Private/Language/Backend/Tceform.xlf'
);
