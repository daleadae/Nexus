<?php

namespace Nexus\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller
{
    public function indexAction()
    {
    	$char_rep = $this->getDoctrine()->getRepository('NexusCoreBundle:Characters');
        $fightLog = $this->container->get('nexus_core.fight_logger');
        return $this->render('NexusCoreBundle:Core:index.html.twig', array(
        				'user' 			=> $this->get('security.context')->getToken()->getUser(),
        				'leaderboard' 	=> $char_rep->getLeaderBoard(),
                        'fightLogs'      => $fightLog->getLastLog(),
        			));
    }
}
