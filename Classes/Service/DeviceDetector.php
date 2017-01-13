<?php
namespace Aoe\AoeAdaptive\Service;

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

use TYPO3\CMS\Core\SingletonInterface;

/**
 * Detects client device type.
 *
 * @author Chetan Thapliyal <chetan.thapliyal@aoe.com>
 */
class DeviceDetector extends \Mobile_Detect implements SingletonInterface
{
    // Device type constants
    const TYPE_MOBILE    = 1;
    const TYPE_PC_TABLET = 2;
}
