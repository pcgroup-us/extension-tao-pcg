<?php

/**
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 * 
 * Copyright (c) 2015 (original work) Open Assessment Technologies SA;
 *               
 * 
 */

namespace pcgroupUs\pcgCore\scripts\install;

class SetTestRunnerConfig extends \common_ext_action_InstallAction
{
    public function __invoke($params)
    {
        $pcgConfig = array(
            'timerWarning' => array(
                'assessmentItemRef' => array(
                    300 => 'warning',
                    120 => 'danger'
                ),
                'assessmentSection' => array(
                    300 => 'warning',
                    120 => 'danger'
                ),
                'testPart'          => array(
                    300 => 'warning',
                    120 => 'danger'
                ),
                'assessmentTest'    => array(
                    300 => 'warning',
                    120 => 'danger'
                )
            ),
            'progress-indicator' => 'position',
            'progress-indicator-scope' => 'testSection',
            'progress-indicator-forced' => true,
            'test-taker-review' => true,
            'test-taker-review-region' => 'left',
            'test-taker-review-force-title' => true,
            'test-taker-review-item-title' => 'Item %d', // forced translation
            'test-taker-review-scope' => 'testSection',
            'test-taker-review-prevents-unseen' => true,
            'test-taker-review-can-collapse' => false,
            'reset-timer-after-resume' => true,
            'next-section' => true,
            'timer' => array(
                'target' => 'client'
            ),
            'test-session' => 'oat\\taoQtiTest\\models\\runner\\session\\TestSession'
        );

        $qtiTest = \common_ext_ExtensionsManager::singleton()->getExtensionById('taoQtiTest');
        $config = $qtiTest->getConfig('testRunner');
        $config = array_merge($config, $pcgConfig);
        $qtiTest->setConfig('testRunner', $config);

        return new \common_report_Report(\common_report_Report::TYPE_SUCCESS, 'Test runner settings added to Tao Qti Test extension');
    }
}



