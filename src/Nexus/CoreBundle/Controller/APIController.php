<?php

namespace Nexus\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializerBuilder;

class APIController extends Controller
{
    public function fightAction()
    {
    	$monster_rep = $this->getDoctrine()->getRepository('NexusCoreBundle:Monster');
    	$user = $this->get('security.context')->getToken()->getUser();
        $fight = $this->container->get('nexus_core.fight_manager');
        $serializer = $this->get('jms_serializer');

        $monsters = $monster_rep->findAll();
        $monster = $monsters[rand(0,count($monsters)-1)];

        $fight->addPlayer($user->getCharacter());
        $fight->addMonster($monster);
        $data = $fight->processFight();

        $json = $serializer->serialize($data, 'json');

        $response = new Response();
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
