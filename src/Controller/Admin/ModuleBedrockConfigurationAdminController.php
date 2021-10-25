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

namespace Kaudaj\Module\ModuleBedrock\Controller\Admin;

use PrestaShop\PrestaShop\Core\Domain\Tab\Command\UpdateTabStatusByClassNameCommand;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShopBundle\Security\Annotation\AdminSecurity;
use PrestaShopBundle\Security\Annotation\DemoRestricted;
use PrestaShopBundle\Security\Annotation\ModuleActivated;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ModuleBedrockConfigurationAdminController
 *
 * @ModuleActivated(moduleName="kjmodulebedrock", redirectRoute="admin_module_manage")
 */
class ModuleBedrockConfigurationAdminController extends FrameworkBundleAdminController
{
    /**
     * @AdminSecurity(
     *     "is_granted(['read'], request.get('_legacy_controller'))",
     *     message="You do not have permission to access this."
     * )
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request): Response
    {
        $formDataHandler = $this->get('kaudaj.module.modulebedrock.form.module_bedrock_configuration_form_data_handler');

        /** @var FormInterface $form */
        $form = $formDataHandler->getForm();

        return $this->renderForm($form);
    }

    /**
     * @param Request $request
     *
     * @AdminSecurity(
     *      "is_granted('update', request.get('_legacy_controller')) && is_granted('create', request.get('_legacy_controller')) && is_granted('delete', request.get('_legacy_controller'))",
     *      message="You do not have permission to update this.",
     *      redirectRoute="back_to_top_configuration"
     * )
     *
     * @DemoRestricted(redirectRoute="module_bedrock_configuration")
     *
     * @return Response
     *
     * @throws \LogicException
     */
    public function processFormAction(Request $request)
    {
        $this->dispatchHook('action' . get_class($this) . 'PostProcessBefore', ['controller' => $this]);

        $formHandler = $this->get('kaudaj.module.modulebedrock.form.module_bedrock_configuration_form_data_handler');

        /** @var FormInterface $form */
        $form = $formHandler->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $saveErrors = $formHandler->save($data);

            if (0 === count($saveErrors)) {
                $this->getCommandBus()->handle(
                    new UpdateTabStatusByClassNameCommand(
                        'AdminShopGroup',
                        $this->configuration->getBoolean('PS_MULTISHOP_FEATURE_ACTIVE')
                    )
                );

                $this->addFlash('success', $this->trans('Successful update.', 'Admin.Notifications.Success'));

                return $this->redirectToRoute('admin_module_bedrock_configuration');
            }

            $this->flashErrors($saveErrors);
        }

        return $this->renderForm($form);
    }

    private function renderForm(FormInterface $form): Response
    {
        return $this->render('@Modules/kjmodulebedrock/views/templates/back/components/layouts/configuration.html.twig', [
            'configuration_form' => $form->createView(),
        ]);
    }
}
