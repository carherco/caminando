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
        $comunidadRepository = $this->getDoctrine()->getRepository('CHCGruposBundle:Comunidad');
        $comunidad = $comunidadRepository->findOneByCodigo($codigo);
        
        $em = $this->getDoctrine()->getEntityManager();
        $query = $em->createQuery("SELECT h.nombre FROM CHCGruposBundle:Hermanos h where h.idComunidad=1 AND h.tipo='matrimonio'");
        $data = $query->getArrayResult();
        
        return new HttpFoundation\JsonResponse($data);
 
    }
    
    public function getSolterosAction($codigo)
    {
        $comunidadRepository = $this->getDoctrine()->getRepository('CHCGruposBundle:Comunidad');
        $comunidad = $comunidadRepository->findOneByCodigo($codigo);
        
        $em = $this->getDoctrine()->getEntityManager();
        $query = $em->createQuery("SELECT h.nombre FROM CHCGruposBundle:Hermanos h where h.idComunidad=1 AND h.tipo='soltero'");
        $data = $query->getArrayResult();
        
        return new HttpFoundation\JsonResponse($data);
 
    }
    
    public function getAusentesAction($codigo)
    {
        $comunidadRepository = $this->getDoctrine()->getRepository('CHCGruposBundle:Comunidad');
        $comunidad = $comunidadRepository->findOneByCodigo($codigo);
        
        $em = $this->getDoctrine()->getEntityManager();
        $query = $em->createQuery("SELECT h.nombre FROM CHCGruposBundle:Hermanos h where h.idComunidad=1 AND h.tipo='ausente'");
        $data = $query->getArrayResult();
        
        return new HttpFoundation\JsonResponse($data);
 
    }
    
    public function postMatrimoniosAction($codigo)
    {
        $request = HttpFoundation\Request::createFromGlobals();
        $data = json_decode($this->get("request")->getContent(), true);
        $nombre = $data['nombre'];
        
        $comunidadRepository = $this->getDoctrine()->getRepository('CHCGruposBundle:Comunidad');
        $comunidad = $comunidadRepository->findOneByCodigo($codigo);
        
        if(!empty($nombre)){
            $matrimonio = new \CHC\GruposBundle\Entity\Hermanos();
            $matrimonio->setIdComunidad($comunidad);
            $matrimonio->setTipo('matrimonio');
            $matrimonio->setNombre($nombre);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($matrimonio);
            $em->flush();
        }

        return new HttpFoundation\JsonResponse(array('nombre'=>$nombre));
 
    }
    
    public function postSolterosAction($codigo)
    {
        $request = HttpFoundation\Request::createFromGlobals();
        $data = json_decode($this->get("request")->getContent(), true);
        $nombre = $data['nombre'];
        
        $comunidadRepository = $this->getDoctrine()->getRepository('CHCGruposBundle:Comunidad');
        $comunidad = $comunidadRepository->findOneByCodigo($codigo);
        
        if(!empty($nombre)){
            $soltero = new \CHC\GruposBundle\Entity\Hermanos();
            $soltero->setIdComunidad($comunidad);
            $soltero->setTipo('soltero');
            $soltero->setNombre($nombre);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($soltero);
            $em->flush();
        }

        return new HttpFoundation\JsonResponse(array('nombre'=>$nombre));
 
    }
    
    public function postAusentesAction($codigo)
    {
        $request = HttpFoundation\Request::createFromGlobals();
        $data = json_decode($this->get("request")->getContent(), true);
        $nombre = $data['nombre'];
        
        $comunidadRepository = $this->getDoctrine()->getRepository('CHCGruposBundle:Comunidad');
        $comunidad = $comunidadRepository->findOneByCodigo($codigo);
        
        if(!empty($nombre)){
            $ausente = new \CHC\GruposBundle\Entity\Hermanos();
            $ausente->setIdComunidad($comunidad);
            $ausente->setTipo('ausente');
            $ausente->setNombre($nombre);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($ausente);
            $em->flush();
        }

        return new HttpFoundation\JsonResponse(array('nombre'=>$nombre));
 
    }
}
