<?php

namespace CHC\GruposBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation;

class GruposController extends Controller
{
    public function indexAction($codigo)
    {
        return $this->render('CHCGruposBundle:Grupos:index.html.twig', array('comunidad' => $codigo));
    }
    
    public function getMatrimoniosAction($codigo)
    {
        
        $em = $this->getDoctrine()->getEntityManager();
        $query = $em->createQuery("SELECT h.nombre FROM CHCGruposBundle:Hermanos h where h.idComunidad=1 AND h.tipo='matrimonio'");
        $data = $query->getArrayResult();
        
        return new HttpFoundation\JsonResponse($data);
 
    }
    
    public function getSolterosAction($codigo)
    {
        
        $em = $this->getDoctrine()->getEntityManager();
        $query = $em->createQuery("SELECT h.nombre FROM CHCGruposBundle:Hermanos h where h.idComunidad=1 AND h.tipo='soltero'");
        $data = $query->getArrayResult();
        
        return new HttpFoundation\JsonResponse($data);
 
    }
    
    public function getAusentesAction($codigo)
    {
        
        $em = $this->getDoctrine()->getEntityManager();
        $query = $em->createQuery("SELECT h.nombre FROM CHCGruposBundle:Hermanos h where h.idComunidad=1 AND h.tipo='ausente'");
        $data = $query->getArrayResult();
        
        return new HttpFoundation\JsonResponse($data);
 
    }
}
