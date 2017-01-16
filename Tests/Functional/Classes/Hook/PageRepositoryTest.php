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
use TYPO3\CMS\Core\Tests\FunctionalTestCase;
use TYPO3\CMS\Frontend\Page\PageRepository;

/**
 * @author Chetan Thapliyal <chetan.thapliyal@aoe.com>
 */
class PageRepositoryTest extends FunctionalTestCase
{
    /**
     * @return void
     */
    public function setUp() {
        // always call setUp after setting the required test extension
        $this->testExtensionsToLoad[] = 'typo3conf/ext/aoe_adaptive';

        parent::setUp();
    }

    /**
     * Checks that PageRepository::enableFields() method generates correct content filter for different device types.
     *
     * @test
     * @dataProvider userAgentsDataProvider
     *
     * @param string $userAgent     Browser User Agent
     * @param string $deviceType    Device Type e.g. PC, Mobile. See DeviceDetector::TYPE_XXX constants.
     */
    public function enableColumns($userAgent, $deviceType)
    {
        $_SERVER['HTTP_USER_AGENT'] = $userAgent;
        $pageRepository = new PageRepository();
        $contentFilter = $pageRepository->enableFields('tt_content');
        $this->assertContains(
            "((FIND_IN_SET('$deviceType', tx_aoeadaptive_devices) OR tx_aoeadaptive_devices = ''))",
            $contentFilter
        );
    }

    /**
     * Provides browser user agents for testing.
     *
     * @return array
     */
    public function userAgentsDataProvider()
    {
        return [
            // Mobiles
            [
                'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 ' .
                '(KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1',
                DeviceDetector::TYPE_MOBILE],
            [
                'Dalvik/2.1.0 (Linux; U; Android 6.0; HTC One M9 Build/MRA58K)',
                DeviceDetector::TYPE_MOBILE
            ],
            [
                'Dalvik/1.6.0 (Linux; U; Android 4.1.2; Nexus 4 Build/KRT16S)',
                DeviceDetector::TYPE_MOBILE
            ],
            [
                'Mozilla/5.0 (compatible; MSIE 10.0; Windows Phone 8.0; Trident/6.0; IEMobile/10.0; ARM; Touch; ' .
                'NOKIA; Lumia 920)',
                DeviceDetector::TYPE_MOBILE
            ],
            [
                'Mozilla/5.0 (Mobile; Windows Phone 8.1; Android 4.0; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; NOKIA; ' .
                'Lumia 520) like iPhone OS 7_0_3 Mac OS X AppleWebKit/537 (KHTML, like Gecko) Mobile Safari/537',
                DeviceDetector::TYPE_MOBILE
            ],
            [
                'Mozilla/5.0 (BlackBerry; U; BlackBerry 9900; en) AppleWebKit/534.11+ (KHTML, like Gecko) Version/7.1.0.346 ' .
                'Mobile Safari/534.11+',
                DeviceDetector::TYPE_MOBILE
            ],
            // Tablets
            [
                'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 ' .
                'Mobile/13B143 Safari/601.1',
                DeviceDetector::TYPE_PC_TABLET
            ],
            // PC/Desktop version
            [
                'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36',
                DeviceDetector::TYPE_PC_TABLET
            ],
            [
                'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0',
                DeviceDetector::TYPE_PC_TABLET
            ],
            [
                'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko',
                DeviceDetector::TYPE_PC_TABLET
            ],
        ];
    }
}
