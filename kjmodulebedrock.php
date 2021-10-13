<?php
/**
 * Copyright since 2019 Kaudaj
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@kaudaj.com so we can send you a copy immediately.
 *
 * @author    Kaudaj <info@kaudaj.com>
 * @copyright Since 2019 Kaudaj
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 */

declare(strict_types=1);

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

use Kaudaj\Module\ModuleBedrock\Form\ModuleBedrockConfiguration;
use PrestaShop\PrestaShop\Adapter\SymfonyContainer;

class KJModuleBedrock extends Module
{
    /**
     * @var array Configuration values
     */
    const CONFIGURATION = [
        ModuleBedrockConfiguration::EXAMPLE_SETTING => 'default_value',
    ];

    /**
     * @var array Hooks to register
     */
    const HOOKS = [
        'exampleHook',
    ];

    public function __construct()
    {
        $this->name = 'kjmodulebedrock';
        $this->tab = 'others';
        $this->version = '1.0.0';
        $this->author = 'Kaudaj';

        $this->ps_versions_compliancy = ['min' => '1.7.8.0', 'max' => _PS_VERSION_];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->trans('Module Bedrock', [], 'Modules.Kjmodulebedrock.Admin');
        $this->description = $this->trans('Boost module development by providing a solid bedrock.', [], 'Modules.Kjmodulebedrock.Admin');

        $this->tabs = [
            [
                'name' => 'Module Bedrock configuration',
                'class_name' => 'AdminModuleBedrockConfiguration',
                'parent_class_name' => 'CONFIGURE',
                'visible' => false,
                'wording' => 'Module Bedrock configuration',
                'wording_domain' => 'Modules.Kjmodulebedrock.Admin',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function isUsingNewTranslationSystem()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function install()
    {
        return parent::install()
            && $this->installConfiguration()
            && $this->registerHook(static::HOOKS);
    }

    /**
     * Install configuration values
     *
     * @return bool
     */
    private function installConfiguration()
    {
        foreach (static::CONFIGURATION as $key => $default_value) {
            if (!Configuration::updateValue($key, $default_value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function uninstall()
    {
        return parent::uninstall()
            && $this->uninstallConfiguration();
    }

    /**
     * Uninstall configuration values
     *
     * @return bool
     */
    private function uninstallConfiguration()
    {
        foreach (static::CONFIGURATION as $key => $default_value) {
            if (!Configuration::deleteByName($key)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get module configuration page content
     */
    public function getContent()
    {
        $route = SymfonyContainer::getInstance()->get('router')->generate('module_bedrock_configuration');
        Tools::redirectAdmin($route);
    }

    /**
     * Example hook
     *
     * @param array $params Hook parameters
     */
    public function hookExampleHook($params)
    {
        /* Do anything */
    }
}
