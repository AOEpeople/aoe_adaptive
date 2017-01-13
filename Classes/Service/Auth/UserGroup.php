<?php
namespace Aoe\AoeAdaptive\Service\Auth;

/*
 * (c) 2016 AOE GmbH <dev@aoe.com>
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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Sv\AbstractAuthenticationService;

class UserGroup extends AbstractAuthenticationService
{
    /**
     * @var \Mobile_Detect
     */
    private $userAgentDetector;

    public function getGroups($user, $existingGroups)
    {
        $userAgentDetector = $this->getUserAgentDetector();
        if ($userAgentDetector && $userAgentDetector->isMobile()) {
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
        $existingGroups[] = $pseudoFrontendGroup;

        return $existingGroups;
    }

    /**
     * Gets an instance of user agent detector class.
     *
     * @return \Mobile_Detect
     */
    protected function getUserAgentDetector()
    {
        if (!($this->userAgentDetector instanceof \Mobile_Detect)) {
            $this->userAgentDetector = GeneralUtility::makeInstance('Mobile_Detect');
        }

        return $this->userAgentDetector;
    }
}
