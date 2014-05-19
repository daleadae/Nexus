<?php

namespace Nexus\AdminBundle\Controller;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Bridge\Monolog\Logger;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Application\Sonata\UserBundle\Entity\User;
use Nexus\CoreBundle\Entity\Characters;
use Nexus\CoreBundle\Entity\WeeklyUpdate;

class WeeklyUpdateAdminController extends Controller
{
    private function updateFields($object)
    {
        return $object;
    }

    /**
     * return the Response object associated to the create action
     *
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @return Response
     */
    public function createAction()
    {
        // the key used to lookup the template
        $templateKey = 'edit';

        if (false === $this->admin->isGranted('CREATE')) {
            throw new AccessDeniedException();
        }

        $object = $this->admin->getNewInstance();

        $this->admin->setSubject($object);

        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->admin->getForm();
        $form->setData($object);

        if ($this->getRestMethod()== 'POST') {
            $update = $this->container->get('nexus_core.update_manager');
            $update->moveFile($this->getRequest()->files);
            $result = $update->parseFile();

            var_dump($result);
            if ($result['status'] == "success") {
                $this->addFlash('sonata_flash_success', $result['info']['message']);
                return $this->redirectTo($object);
            } else {
                $this->addFlash('sonata_flash_error', $result['info']['message']);
            }
        }

        $view = $form->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());

        return $this->render($this->admin->getTemplate($templateKey), array(
            'action' => 'create',
            'form'   => $view,
            'object' => $object,
        ));
    }
}