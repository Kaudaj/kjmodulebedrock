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

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShopBundle\Security\Annotation\AdminSecurity;
use PrestaShopBundle\Security\Annotation\ModuleActivated;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ModuleBedrockConfigurationAdminController.
 *
 * @ModuleActivated(moduleName="kjmodulebedrock", redirectRoute="admin_module_manage")
 */

class ModuleBedrockConfigurationAdminController extends FrameworkBundleAdminController
{
    /**
     * @AdminSecurity("is_granted(['read', 'post'], request.get('_legacy_controller'))", message="Access denied.")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request): Response
    {
        $formDataHandler = $this->get('kaudaj.module.modulebedrock.form.module_bedrock_configuration_form_data_handler');

        $form = $formDataHandler->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** You can return array of errors in form handler and they can be displayed to user with flashErrors */
            $errors = $formDataHandler->save($form->getData());

            if (empty($errors)) {
                $this->addFlash('success', $this->trans('Successful update.', 'Admin.Notifications.Success'));

                return $this->redirectToRoute('module_bedrock_configuration');
            }

            $this->flashErrors($errors);
        }

        return $this->render('@Modules/kjmodulebedrock/views/templates/components/layouts/configuration.html.twig', [
            'configuration_form' => $form->createView(),
        ]);
    }
}
