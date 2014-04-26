<?php

namespace Nexus\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller
{
    public function indexAction()
    {
    	$char_rep = $this->getDoctrine()->getRepository('NexusCoreBundle:Characters');
    	$user = $this->get('security.context')->getToken()->getUser();
    	$leaderboard = $char_rep->getLeaderBoard();
    	//var_dump($user->getCharacter()->getPower());
        return $this->render('NexusCoreBundle:Core:index.html.twig', array(
        				'user' 			=> $user,
        				'leaderboard' 	=> $leaderboard
        			));
    }
}
