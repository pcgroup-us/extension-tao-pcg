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
 *
 *
 */

namespace pcgroupUs\pcgCore\scripts\install;

// Item themes
use oat\tao\model\ThemeRegistry;
use Jig\Utils\StringUtils;

// Platform themes
use pcgroupUs\pcgCore\model\theme\PcgDefaultTheme;
use oat\oatbox\service\ServiceManager;
use oat\tao\model\theme\ThemeService;

class SetThemeConfig extends \common_ext_action_InstallAction
{
    public function __invoke($params)
    {
        // Item themes
        // 'camelCaseId' => 'Name of the theme'
        $itemThemes = array(
            'themePcg' => 'Theme Pcg'
        );

        // override if required
        $defaultTheme = 'themePcg';

        foreach($itemThemes as $themeName){
            $pathFragment = StringUtils::removeSpecChars($themeName);
            $themeId = StringUtils::camelize($pathFragment);
            ThemeRegistry::getRegistry()->registerTheme(
                $themeId,
                $themeName,
                implode(DIRECTORY_SEPARATOR, array('pcgCore', 'views', 'css', 'themes', 'items', $pathFragment, 'theme.css')), array('items')
            );
        }

        ThemeRegistry::getRegistry()->setDefaultTheme('items', $defaultTheme);

        // TAO theme would usually be removed from the stack if custom themes are used
        // Make sure another theme has been set to default in this case.
        if($defaultTheme !== 'tao') {
            try {
                ThemeRegistry::getRegistry()->unregisterTheme('tao');
            } catch(ThemeNotFoundException $e) {
                // theme was already deleted, nothing to worry about
            }
        }


        // Platform themes
        $serviceManager = ServiceManager::getServiceManager();
        $themeService = $serviceManager->get(ThemeService::SERVICE_ID);

        $themeService->setTheme(new PcgDefaultTheme());
        $serviceManager->register(ThemeService::SERVICE_ID, $themeService);

        return new \common_report_Report(\common_report_Report::TYPE_SUCCESS, 'Test runner settings added to Tao Qti Test extension');
    }
}
