<?php

namespace Nexus\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller
{
    public function indexAction()
    {
	    // J'ai raccourci cette partie, car c'est plus rapide à écrire !
	    $form = $this->createFormBuilder(array())
	                 ->add('titre',       'text')
	                 ->add('file',     'file')
	                 ->getForm();

	    // On récupère la requête
	    $request = $this->get('request');

	    // On vérifie qu'elle est de type POST
	    if ($request->getMethod() == 'POST') {
	      // On fait le lien Requête <-> Formulaire
	      // À partir de maintenant, la variable $article contient les valeurs entrées dans le formulaire par le visiteur
	      $form->bind($request);

	      	var_dump($this->getRequest()->files);
            var_dump($this->getRequest()->request->all());
            var_dump($this->getRequest()->query->all());

	      // On vérifie que les valeurs entrées sont correctes
	      // (Nous verrons la validation des objets en détail dans le prochain chapitre)
	      if ($form->isValid()) {
	        // On l'enregistre notre objet $article dans la base de données
	        /*$em = $this->getDoctrine()->getManager();
	        $em->persist($article);
	        $em->flush();

	        // On redirige vers la page de visualisation de l'article nouvellement créé
	        return $this->redirect($this->generateUrl('sdzblog_voir', array('id' => $article->getId())));*/
	        var_dump("VALIDE");
	      }
	    }


        return $this->render('NexusCoreBundle:Core:index.html.twig', array('form' => $form->createView()));
    }
}
