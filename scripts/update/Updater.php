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
 * Copyright (c) 2016 (original work) Open Assessment Technologies SA;
 */

namespace pcgroupUs\pcgCore\scripts\update;

/**
 * @author Ivan Klimchuk <klimchuk@1pt.com>
 */
class Updater extends \common_ext_ExtensionUpdater
{
    /**
     * @param string $initialVersion
     * @return string $versionUpdatedTo
     */
    public function update($initialVersion)
    {
        if ($this->isVersion('1.0.0')) {

            $testRunnerConfig = \common_ext_ExtensionsManager::singleton()->getExtensionById('taoQtiTest')->getConfig('testRunner');

            if (array_key_exists('timerWarning', $testRunnerConfig)) {
                foreach ($testRunnerConfig['timerWarning'] as &$value) {
                    $value = array(
                        300 => 'warning',
                        120 => 'error'
                    );
                }

                \common_ext_ExtensionsManager::singleton()->getExtensionById('taoQtiTest')->setConfig('testRunner', $testRunnerConfig);
            }

            $this->setVersion('1.0.1');
        }

        if ($this->isVersion('1.0.1')) {

            $testRunnerConfig = \common_ext_ExtensionsManager::singleton()->getExtensionById('taoQtiTest')->getConfig('testRunner');
            $testRunnerConfig['test-session'] = 'oat\\taoQtiTest\\models\\runner\\session\\TestSession';
            \common_ext_ExtensionsManager::singleton()->getExtensionById('taoQtiTest')->setConfig('testRunner', $testRunnerConfig);

            $this->setVersion('1.0.2');
        }

        if ($this->isVersion('1.0.2')) {

            $testRunnerConfig = \common_ext_ExtensionsManager::singleton()->getExtensionById('taoQtiTest')->getConfig('testRunner');

            if (array_key_exists('timerWarning', $testRunnerConfig)) {
                foreach ($testRunnerConfig['timerWarning'] as &$value) {
                    $value = array_map(function ($row) {
                        return $row !== 'error' ? $row : 'danger';
                    }, $value);
                }

                \common_ext_ExtensionsManager::singleton()->getExtensionById('taoQtiTest')->setConfig('testRunner', $testRunnerConfig);
            }

            $this->setVersion('1.0.3');
        }
    }
}
