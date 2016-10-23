<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PublicController extends Controller
{

    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {

        return $this->render('BlogBundle:Public:index.html.twig');
    }

    /**
     * @Route("/about", name="about")
     */
    public function aboutAction()
    {
        return $this->render('BlogBundle:Public:about.html.twig');
    }
}
