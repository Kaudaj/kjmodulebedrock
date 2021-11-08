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

use Kaudaj\Module\ModuleBedrock\Form\PreferencesConfiguration;
use PrestaShop\PrestaShop\Adapter\Configuration;
use PrestaShop\PrestaShop\Adapter\SymfonyContainer;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class KJModuleBedrock extends Module
{
    /**
     * @var array<string, string> Configuration values
     */
    const CONFIGURATION_VALUES = [
        PreferencesConfiguration::EXAMPLE_SETTING_KEY => 'default_value',
    ];

    /**
     * @var string[] Hooks to register
     */
    const HOOKS = [
        'exampleHook',
    ];

    /**
     * @var Configuration<string, mixed> Configuration
     */
    private $configuration;

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
                'name' => 'Module Bedrock Configuration',
                'class_name' => 'ModuleBedrockConfiguration',
                'parent_class_name' => 'CONFIGURE',
                'visible' => false,
                'wording' => 'Module Bedrock Configuration',
                'wording_domain' => 'Modules.Kjmodulebedrock.Admin',
            ],
        ];

        $this->configuration = new Configuration();
    }

    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function isUsingNewTranslationSystem()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function install()
    {
        return parent::install()
            && $this->installConfiguration()
            && $this->registerHook(self::HOOKS);
    }

    /**
     * Install configuration values
     *
     * @return bool
     */
    private function installConfiguration()
    {
        try {
            //TODO: Fix le bug quand une valeur est set pour un shop
            foreach (self::CONFIGURATION_VALUES as $key => $default_value) {
                $this->configuration->set($key, $default_value);
            }
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     *
     * @return bool
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
        try {
            foreach (array_keys(self::CONFIGURATION_VALUES) as $key) {
                $this->configuration->remove($key);
            }
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Get module configuration page content
     *
     * @return void
     */
    public function getContent()
    {
        $container = SymfonyContainer::getInstance();

        if ($container != null) {
            /** @var UrlGeneratorInterface */
            $router = $container->get('router');

            Tools::redirectAdmin($router->generate('module_bedrock_configuration'));
        }
    }

    /**
     * Example hook
     *
     * @param array<string, mixed> $params Hook parameters
     *
     * @return void
     */
    public function hookExampleHook($params)
    {
        /* Do anything */
    }
}
