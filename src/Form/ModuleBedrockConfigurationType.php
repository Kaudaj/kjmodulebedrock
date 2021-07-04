<?php

declare(strict_types=1);

namespace Kaudaj\Module\ModuleBedrock\Form;

use PrestaShop\PrestaShop\Core\ConstraintValidator\Constraints\TypedRegex;
use PrestaShopBundle\Form\Admin\Type\TranslatableType;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\FormBuilderInterface;

class ModuleBedrockConfigurationType extends TranslatorAwareType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('example_setting', TranslatableType::class, [
                'label' => $this->trans('Example setting', 'Modules.Kjmodulebedrock.Admin'),
                'help' => $this->trans('Throws error if text contains <>={}', 'Modules.Kjmodulebedrock.Admin'),
                'options' => [
                    'constraints' => [
                        new TypedRegex([
                            'type' => 'generic_name',
                        ]),
                    ],
                ],
            ]);
    }
}
