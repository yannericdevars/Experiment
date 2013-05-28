<?php

namespace DW\EntityManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Page par defaut
 */
class DefaultController extends Controller
{
  /**
   * Page d'accueil
   * @param string $name Nom
   * 
   * @return Twig Template
   */
    public function indexAction($name)
    {
        return $this->render('DWEntityManagerBundle:Default:index.html.twig', array('name' => $name));
    }
}
