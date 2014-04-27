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
    public function checkNode($node)
    {
        return (isset($node) && (!empty($node) || $node == '0')) ? $node : null;
    }

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
            /*$form->bind($this->get('request'));*/

            $files = $this->getRequest()->files;
            foreach ($files as $file) {
                $file = $file['file'];
            }
            $dir = __DIR__.'/../Resources/public/xml';
            $file->move($dir, 'Nexus.xml');

            $xml = simplexml_load_file($dir.'/Nexus.xml');
            if ($xml) {
                $error = false;
                $error_log = '';
                $char_rep = $this->getDoctrine()->getRepository('NexusCoreBundle:Characters');
                $update_rep = $this->getDoctrine()->getRepository('NexusCoreBundle:WeeklyUpdate');
                $validator = $this->get('validator');
                $entityManager = $this->getDoctrine()->getManager();

                foreach ($xml->record as $update) {
                    $character = $char_rep->find($update->char_id);
                    if (!$character) {
                        $error = true;
                        $error_log .= 'Wrong or empty character ID.<br/>';
                        break;
                    } else {
                        $weeklyUpdate = new WeeklyUpdate;

                        $weeklyUpdate->setExperience1($this->checkNode((string)$update->xp1));
                        $weeklyUpdate->setExperience2($this->checkNode((string)$update->xp2));
                        $weeklyUpdate->setDamage1($this->checkNode((string)$update->dmg1));
                        $weeklyUpdate->setDamage2($this->checkNode((string)$update->dmg2));
                        $weeklyUpdate->setArmor($this->checkNode((string)$update->armor));
                        $weeklyUpdate->setResist($this->checkNode((string)$update->resist));
                        $weeklyUpdate->setMitigation($this->checkNode((string)$update->mitigation));
                        $weeklyUpdate->setAttackSpeed($this->checkNode((string)$update->as));
                        $damageTaken = floor(((float)$update->dmg1*1.5 + $update->dmg2)*(1-(float)$update->mitigation));
                        $weeklyUpdate->setHealthLost($damageTaken);

                        $character->processDamageTaken($damageTaken);
                        $character->setAttackSpeed((float)$update->as);
                        $character->setFight(3);
                        $power = 1 + ($character->getLevel() - 1)/10;
                        $character->setPower($power);
                        $character->addUpdate($weeklyUpdate);

                        $errorList = $validator->validate($weeklyUpdate);

                        if (count($errorList) > 0) {
                            $error = true;
                            foreach ($errorList as $errors) {
                                $error_log .= '<strong>'.$errors->getPropertyPath().'</strong>: '.$errors->getMessage().' ('.$character->getName().')<br/>';
                            }
                        } else  {
                           $entityManager->persist($character);           
                        }
                    }
                }

                if (!$error) {
                    $entityManager->flush();
                    $this->addFlash('sonata_flash_success', $this->admin->trans('flash_create_success', array('%name%' => $this->admin->toString($object)), 'SonataAdminBundle'));

                    return $this->redirectTo($object);
                } else {
                    $this->addFlash('sonata_flash_error', $this->admin->trans($error_log));
                }
            } else {
                if (!$this->isXmlHttpRequest()) {
                    $this->addFlash('sonata_flash_error', $this->admin->trans('flash_create_error', array('%name%' => $this->admin->toString($object)), 'SonataAdminBundle'));
                }                
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