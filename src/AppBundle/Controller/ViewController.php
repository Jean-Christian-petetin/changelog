<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ViewController extends Controller{
    /**
     * @Route("/", name="accueil")
     * @Template(":default:index.html.twig")
     */
    public function indexAction(){
        return null;
    }
    
    /**
     * @Route("/changelog", name="changelog")
     * @Template(":default:changelog.html.twig")
     */
    public function newsAction(){
        $em = $this->getDoctrine()->getManager(); //On appelle l'entity manager de Doctrine.
        $news = $em->getRepository("AppBundle:News")->findAll(); //On va chercher en DB toutes les instances existantes.
        return array("varNews" => $news); //On lie ce que l'on a recuperer en DB avec notre vue.
    }
    
    /**
     * @Route("/admin", name="admin")
     * @Template(":default:admin.html.twig")
     */
    public function getNews() {
        $em = $this->getDoctrine()->getManager(); //On appelle l'entity manager de Doctrine.
        $news = $em->getRepository("AppBundle:News")->findAll(); //On va chercher en DB toutes les instances existantes.
        return array("varNews" => $news); //On lie ce que l'on a recuperer en DB avec notre vue.
    }
}
