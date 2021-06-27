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

if (!defined('_PS_VERSION_')) {
    exit;
}

class KJModuleBedrock extends Module
{
    //Configuration values
    const CONFIGURATION = [
        'KJMODULEBEDROCK_EXAMPLE_SETTING' => 'default_value',
    ];

    //Hooks to register
    const HOOKS = [
        'exampleHook',
    ];

    public function __construct()
    {
        $this->name = 'kjmodulebedrock';
        $this->tab = 'other';
        $this->version = '1.0.0';
        $this->author = 'Kaudaj';

        $this->ps_versions_compliancy = ['min' => '1.7.1.0', 'max' => _PS_VERSION_];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Module Bedrock');
        $this->description = $this->l('Boost module development by providing a solid bedrock.');
    }

    public function install()
    {
        return parent::install()
            && $this->installConfiguration()
            && $this->registerHooks();
    }

    private function installConfiguration()
    {
        foreach (self::CONFIGURATION as $key => $default_value) {
            if (!Configuration::updateValue($key, $default_value)) {
                return false;
            }
        }

        return true;
    }

    private function registerHooks()
    {
        foreach (self::HOOKS as $hook) {
            if (!$this->registerHook($hook)) {
                return false;
            }
        }

        return true;
    }

    public function uninstall()
    {
        return parent::uninstall()
            && $this->uninstallConfiguration()
            && $this->unregisterHooks();
    }

    private function uninstallConfiguration()
    {
        foreach (self::CONFIGURATION as $key => $default_value) {
            if (!Configuration::deleteByName($key)) {
                return false;
            }
        }

        return true;
    }

    public function unregisterHooks()
    {
        foreach (self::HOOKS as $hook) {
            if (!$this->unregisterHook($hook)) {
                return false;
            }
        }

        return true;
    }

    public function hookExampleHook($params)
    {
        /* Do anything */
    }

    public function getContent()
    {
        if (((bool) Tools::isSubmit('submit' . $this->name)) == true) {
            $this->postProcess();
        }

        return $this->renderForm();
    }

    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;

        $defaultLang = (int) Configuration::get('PS_LANG_DEFAULT');
        $helper->default_form_language = $defaultLang;
        $helper->allow_employee_form_lang = $defaultLang;

        $helper->title = $this->displayName;
        $helper->show_toolbar = true;
        $helper->toolbar_scroll = true;
        $helper->submit_action = 'submit' . $this->name;
        $helper->toolbar_btn = [
            'save' => [
                'desc' => $this->trans('Save', [], 'Admin.Actions'),
                'href' => AdminController::$currentIndex . '&configure=' . $this->name . '&save' . $this->name .
                '&token=' . Tools::getAdminTokenLite('AdminModules'),
            ],
            'back' => [
                'href' => AdminController::$currentIndex . '&token=' . Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->trans('Back to list', [], 'Admin.Actions'),
            ],
        ];

        $helper->fields_value = $this->getConfigFormFieldsValues();

        return $helper->generateForm($this->getConfigFormFields());
    }

    protected function getConfigFormFields()
    {
        $fieldsForm = [
            [
                'form' => [
                    'legend' => [
                        'title' => $this->trans('Settings', [], 'Admin.Global'),
                    ],
                    'input' => [
                        [
                            'col' => 3,
                            'type' => 'text',
                            'prefix' => '<i class="icon icon-cogs"></i>',
                            'desc' => $this->l('Describe the setting'),
                            'name' => 'KJMODULEBEDROCK_EXAMPLE_SETTING',
                            'label' => $this->l('Example setting'),
                        ],
                    ],
                    'submit' => [
                        'title' => $this->trans('Save', [], 'Admin.Actions'),
                        'class' => 'btn btn-default pull-right',
                    ],
                ],
            ],
        ];

        return $fieldsForm;
    }

    public function getConfigFormFieldsValues()
    {
        $configuration_values = [];

        foreach (self::CONFIGURATION as $key => $default_value) {
            $configuration_values[] = Tools::getValue($key, Configuration::get($key));
        }

        return $configuration_values;
    }

    protected function postProcess()
    {
        $updated = true;

        foreach (self::CONFIGURATION as $key => $default_value) {
            $updated = Configuration::updateValue($key, Tools::getValue($key));
        }

        return $updated ?
            $this->displayConfirmation(
                $this->trans('The settings have been updated.', [], 'Admin.Notifications.Success')
            )
            : $this->displayError(
                $this->trans('Unable to update settings.', [], 'Admin.Notifications.Error')
            );
    }
}
