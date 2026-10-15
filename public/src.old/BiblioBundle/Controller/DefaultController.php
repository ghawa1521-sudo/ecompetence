<?php

namespace BiblioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BiblioBundle:Default:index.html.twig', array('name' => $name));
    }
}
