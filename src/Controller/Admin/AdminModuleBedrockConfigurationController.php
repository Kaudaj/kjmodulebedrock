<?php
declare(strict_types=1);

namespace Kaudaj\Module\ModuleBedrock\Controller\Admin;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShopBundle\Security\Annotation\AdminSecurity;
use PrestaShopBundle\Security\Annotation\ModuleActivated;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AdminModuleBedrockConfigurationController.
 *
 * @ModuleActivated(moduleName="kjmodulebedrock", redirectRoute="admin_module_manage")
 */
class AdminModuleBedrockConfigurationController extends FrameworkBundleAdminController
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

        return $this->render('@Modules/kjmodulebedrock/views/templates/admin/configuration_form.html.twig', [
            'configuration_form' => $form->createView(),
        ]);
    }
}