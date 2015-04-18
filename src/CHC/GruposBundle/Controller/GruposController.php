<?php

namespace CHC\GruposBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GruposController extends Controller
{
    public function indexAction($codigo)
    {
        return $this->render('CHCGruposBundle:Grupos:index.html.twig', array('name' => $codigo));
    }
}
