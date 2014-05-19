<?php

namespace Nexus\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TutorialController extends Controller
{
    public function indexAction()
    {
  return $this->render('NexusCoreBundle:Tutorial:index.html.twig');
    }
}
