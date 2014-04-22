<?php

namespace Nexus\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('NexusCoreBundle:Default:index.html.twig', array('name' => $name));
    }
}
