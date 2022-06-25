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

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

class KJModuleBedrock extends Module
{
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
        $this->description = $this->trans(<<<EOF
        Boost module development by providing a solid bedrock.
EOF
            ,
            [],
            'Modules.Kjmodulebedrock.Admin'
        );

        $this->tabs = [
            [
                'name' => 'Module Bedrock Settings',
                'class_name' => 'KJModuleBedrockSettings',
                'route_name' => 'kj_module_bedrock_settings',
                'parent_class_name' => 'CONFIGURE',
                'visible' => false,
                'wording' => 'Module Bedrock Settings',
                'wording_domain' => 'Modules.Kjmodulebedrock.Admin',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function isUsingNewTranslationSystem(): bool
    {
        return true;
    }
}
