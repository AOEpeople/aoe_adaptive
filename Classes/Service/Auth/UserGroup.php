<?php
namespace Aoe\AoeAdaptive\Service\Auth;

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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Sv\AbstractAuthenticationService;

/**
 * Assigns pseudo user groups to frontend users.
 *
 * @author Chetan Thapliyal <chetan.thapliyal@aoe.com>
 */
class UserGroup extends AbstractAuthenticationService
{
    /**
     * Assigns a pseudo user group to frontend user depending on his device type.
     *
     * @param  array $user       User and session data.
     * @param  array $groups     Existing user groups, if any.
     * @return array
     */
    public function getGroups(array $user = null, array $groups)
    {
        $deviceDetector = GeneralUtility::makeInstance(DeviceDetector::class);
        if ($deviceDetector && $deviceDetector->isMobile()) {
            $pseudoFrontendGroup = [
                'title' => 'Frontend: Mobile',
                'uid'   => '-333'
            ];
        } else {
            $pseudoFrontendGroup = [
                'title' => 'Frontend: Tablet/PC',
                'uid'   => '-444'
            ];
        }

        $pseudoFrontendGroup['pid'] = '';
        $groups[] = $pseudoFrontendGroup;

        return $groups;
    }
}
