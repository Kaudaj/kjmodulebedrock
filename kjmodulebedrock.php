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

use Kaudaj\Module\ModuleBedrock\Form\Configuration\GeneralConfiguration;
use Kaudaj\Module\ModuleBedrock\Form\Type\GeneralType;
use PrestaShop\PrestaShop\Adapter\SymfonyContainer;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

if (!defined('_PS_VERSION_')) {
    exit;
}

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

class KJModuleBedrock extends Module
{
    public const HOOKS = [
        'actionFrontControllerSetMedia',
    ];

    public function __construct()
    {
        $this->name = 'kjmodulebedrock';
        $this->tab = 'others';
        $this->version = '1.1.0';
        $this->author = 'Kaudaj';
        $this->ps_versions_compliancy = ['min' => '8.0.0', 'max' => '8.99.99'];

        $this->bootstrap = true;

        $this->tabs = [
            [
                'class_name' => 'KJModuleBedrockSettings',
                'route_name' => 'kj_module_bedrock_settings',
                'name' => 'Module Bedrock',
                'wording' => 'Module Bedrock',
                'wording_domain' => 'Modules.Kjmodulebedrock.Admin',
                'parent_class_name' => 'CONFIGURE',
                'visible' => false,
            ],
        ];

        parent::__construct();

        $this->displayName = $this->trans('Module Bedrock', [], 'Modules.Kjmodulebedrock.Admin');
        $this->description = $this->trans(
            'Boost module development by providing a solid bedrock.',
            [],
            'Modules.Kjmodulebedrock.Admin'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function isUsingNewTranslationSystem(): bool
    {
        return true;
    }

    public function install(): bool
    {
        return parent::install()
            && $this->registerHook(self::HOOKS)
        ;
    }

    public function uninstall(): bool
    {
        return parent::uninstall()
            && Configuration::deleteByName(GeneralConfiguration::getConfigurationKey(GeneralType::FIELD_EXAMPLE_SETTING))
        ;
    }

    public function getContent(): void
    {
        $container = SymfonyContainer::getInstance();

        if ($container != null) {
            /** @var UrlGeneratorInterface $router */
            $router = $container->get('router');

            Tools::redirectAdmin($router->generate('kj_module_bedrock_settings'));
        }
    }

    public function hookActionFrontControllerSetMedia(): void
    {
        $controller = $this->context->controller;

        if (!$controller instanceof FrontController) {
            return;
        }

        if (file_exists(_PS_MODULE_DIR_ . $this->name . '/views/css/front.css')) {
            $controller->registerStylesheet(
                'modules-' . $this->name . '-front',
                'modules/' . $this->name . '/views/css/front.css',
                ['media' => 'all', 'priority' => 150]
            );
        }

        if (file_exists(_PS_MODULE_DIR_ . $this->name . '/views/js/front.js')) {
            $controller->registerJavascript(
                'modules-' . $this->name . '-front',
                'modules/' . $this->name . '/views/js/front.js',
                ['position' => 'bottom', 'priority' => 150, 'attribute' => 'defer']
            );
        }
    }
}
