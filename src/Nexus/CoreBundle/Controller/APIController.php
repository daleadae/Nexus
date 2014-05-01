<?php

namespace Nexus\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializerBuilder;

class APIController extends Controller
{
    public function fightAction()
    {
    	$fight = $this->container->get('nexus_core.fight_manager');
        $fightLog = $this->container->get('nexus_core.fight_logger');
        $char_rep = $this->getDoctrine()->getRepository('NexusCoreBundle:Characters');
        $serializer = $this->get('jms_serializer');

        $data = $fight->launchFight();

        $fightLogs = $fightLog->getLastLog();

        $data['eventLog_HTML'] = $this->renderView(
            'NexusCoreBundle:Core:event.html.twig',
            array('fightLogs' => $fightLogs)
        );

        $json = $serializer->serialize($data, 'json');

        $leaderboard = $char_rep->getLeaderBoard();

        $data['leaderboard_HTML'] = $this->renderView(
            'NexusCoreBundle:Core:leaderboard.html.twig',
            array('leaderboard' => $leaderboard)
        );

        $response = new Response();
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function eventAction()
    {
        $fightLog = $this->container->get('nexus_core.fight_logger');
        $serializer = $this->get('jms_serializer');

        $fightLogs = $fightLog->getLastLog();

        $data['eventLog_HTML'] = $this->renderView(
            'NexusCoreBundle:Core:event.html.twig',
            array('fightLogs' => $fightLogs)
        );
        $json = $serializer->serialize($data, 'json');

        $response = new Response();
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function leaderboardAction()
    {
        $char_rep = $this->getDoctrine()->getRepository('NexusCoreBundle:Characters');
        $serializer = $this->get('jms_serializer');

        $leaderboard = $char_rep->getLeaderBoard();

        $data['leaderboard_HTML'] = $this->renderView(
            'NexusCoreBundle:Core:leaderboard.html.twig',
            array('leaderboard' => $leaderboard)
        );
        $json = $serializer->serialize($data, 'json');

        $response = new Response();
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }        
}
