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

namespace Kaudaj\Module\ModuleBedrock\Form\Type;

use Kaudaj\Module\ModuleBedrock\Form\Configuration\GeneralConfiguration;
use PrestaShopBundle\Form\Admin\Type\MultistoreConfigurationType;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;

class GeneralType extends TranslatorAwareType
{
    public const FIELD_EXAMPLE_SETTING = 'example_setting';

    /**
     * {@inheritdoc}
     *
     * @param FormBuilderInterface<string, mixed> $builder
     * @param array<string, mixed> $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(self::FIELD_EXAMPLE_SETTING, TextType::class, [
                'label' => $this->trans('Example setting', 'Modules.Kjmodulebedrock.Admin'),
                'help' => $this->trans(
                    'Sample value stored in the shop configuration. Replace it with your own settings.',
                    'Modules.Kjmodulebedrock.Admin'
                ),
                'required' => false,
                'empty_data' => '',
                'multistore_configuration_key' => GeneralConfiguration::getConfigurationKey(self::FIELD_EXAMPLE_SETTING),
                'constraints' => [
                    new Length(['max' => 255]),
                ],
            ])
        ;
    }

    /**
     * {@inheritdoc}
     *
     * @see MultistoreConfigurationTypeExtension
     */
    public function getParent(): string
    {
        return MultistoreConfigurationType::class;
    }
}
