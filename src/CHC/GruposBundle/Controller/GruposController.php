<?php

namespace CHC\GruposBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation;
use CHC\GruposBundle\Entity;

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
        
        $data = array();
        if($comunidad instanceof Entity\Comunidad){
            $id_comunidad = $comunidad->getId();
            $em = $this->getDoctrine()->getEntityManager();
            $query = $em->createQuery("SELECT h.id, h.nombre FROM CHCGruposBundle:Hermanos h where h.idComunidad=$id_comunidad AND h.tipo='matrimonio'");
            $data = $query->getArrayResult();
        }
        
        
        
        return new HttpFoundation\JsonResponse($data);
 
    }
    
    public function getSolterosAction($codigo)
    {
        $comunidadRepository = $this->getDoctrine()->getRepository('CHCGruposBundle:Comunidad');
        $comunidad = $comunidadRepository->findOneByCodigo($codigo);
        
        $data = array();
        if($comunidad instanceof Entity\Comunidad){
            $id_comunidad = $comunidad->getId();
            $em = $this->getDoctrine()->getEntityManager();
            $query = $em->createQuery("SELECT h.id, h.nombre FROM CHCGruposBundle:Hermanos h where h.idComunidad=$id_comunidad AND h.tipo='soltero'");
            $data = $query->getArrayResult();
        }
        
        return new HttpFoundation\JsonResponse($data);
 
    }
    
    public function getAusentesAction($codigo)
    {
        $comunidadRepository = $this->getDoctrine()->getRepository('CHCGruposBundle:Comunidad');
        $comunidad = $comunidadRepository->findOneByCodigo($codigo);
        
        $data = array();
        if($comunidad instanceof Entity\Comunidad){
            $id_comunidad = $comunidad->getId();
            $em = $this->getDoctrine()->getEntityManager();
            $query = $em->createQuery("SELECT h.id, h.nombre FROM CHCGruposBundle:Hermanos h where h.idComunidad=$id_comunidad AND h.tipo='ausente'");
            $data = $query->getArrayResult();
        }
        
        return new HttpFoundation\JsonResponse($data);
 
    }
    
    public function postMatrimoniosAction($codigo)
    {
        $data = json_decode($this->get("request")->getContent(), true);
        $nombre = $data['nombre'];
        
        $comunidadRepository = $this->getDoctrine()->getRepository('CHCGruposBundle:Comunidad');
        $comunidad = $comunidadRepository->findOneByCodigo($codigo);
        
        if(!empty($nombre)){
            $matrimonio = new Entity\Hermanos();
            $matrimonio->setIdComunidad($comunidad);
            $matrimonio->setTipo('matrimonio');
            $matrimonio->setNombre($nombre);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($matrimonio);
            $em->flush();
        }

        return new HttpFoundation\JsonResponse(array('id'=>$matrimonio->getId(),'nombre'=>$matrimonio->getNombre()));
 
    }
    
    public function postSolterosAction($codigo)
    {
        $data = json_decode($this->get("request")->getContent(), true);
        $nombre = $data['nombre'];
        
        $comunidadRepository = $this->getDoctrine()->getRepository('CHCGruposBundle:Comunidad');
        $comunidad = $comunidadRepository->findOneByCodigo($codigo);
        
        if(!empty($nombre)){
            $soltero = new Entity\Hermanos();
            $soltero->setIdComunidad($comunidad);
            $soltero->setTipo('soltero');
            $soltero->setNombre($nombre);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($soltero);
            $em->flush();
        }

        return new HttpFoundation\JsonResponse(array('id'=>$soltero->getId(),'nombre'=>$soltero->getNombre()));
 
    }
    
    public function postAusentesAction($codigo)
    {
        $data = json_decode($this->get("request")->getContent(), true);
        $nombre = $data['nombre'];
        
        $comunidadRepository = $this->getDoctrine()->getRepository('CHCGruposBundle:Comunidad');
        $comunidad = $comunidadRepository->findOneByCodigo($codigo);
        
        if(!empty($nombre)){
            $ausente = new Entity\Hermanos();
            $ausente->setIdComunidad($comunidad);
            $ausente->setTipo('ausente');
            $ausente->setNombre($nombre);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($ausente);
            $em->flush();
        }

        return new HttpFoundation\JsonResponse(array('id'=>$ausente->getId(),'nombre'=>$ausente->getNombre()));
 
    }
    
    public function deleteHermanosAction($codigo,$id)
    {
        $comunidadRepository = $this->getDoctrine()->getRepository('CHCGruposBundle:Comunidad');
        $comunidad = $comunidadRepository->findOneByCodigo($codigo);
        
        $hermanosRepository = $this->getDoctrine()->getRepository('CHCGruposBundle:Hermanos');
        $hermano = $hermanosRepository->find($id);
        
        if($hermano instanceof Entity\Hermanos && $comunidad instanceof Entity\Comunidad){
            if($hermano->getIdComunidad()->getId() === $comunidad->getId()){
                $em = $this->getDoctrine()->getManager();
                $em->remove($hermano);
                $em->flush();
            }
        }

        return new HttpFoundation\JsonResponse(array('deleted'));
 
    }
    
}
