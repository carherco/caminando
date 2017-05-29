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
    
    public function getHermanosAction($codigo)
    {
        $comunidadRepository = $this->getDoctrine()->getRepository('CHCGruposBundle:Comunidad');
        $comunidad = $comunidadRepository->findOneByCodigo($codigo);
        
        $data = array();
        if($comunidad instanceof Entity\Comunidad){
            $id_comunidad = $comunidad->getId();
            $em = $this->getDoctrine()->getEntityManager();
            $query = $em->createQuery("SELECT h.id, h.nombre, h.ausente FROM CHCGruposBundle:Hermano h where h.comunidad=$id_comunidad ORDER BY h.nombre");
            $data = $query->getArrayResult();
        }
        
        return  new HttpFoundation\JsonResponse($data);
 
    }
    
    public function getMatrimoniosAction($codigo)
    {
        $comunidadRepository = $this->getDoctrine()->getRepository('CHCGruposBundle:Comunidad');
        $comunidad = $comunidadRepository->findOneByCodigo($codigo);
        
        $data = array();
        if($comunidad instanceof Entity\Comunidad){
            $id_comunidad = $comunidad->getId();
            $em = $this->getDoctrine()->getEntityManager();
            $query = $em->createQuery("SELECT h.id, h.nombre FROM CHCGruposBundle:Hermano h where h.comunidad=$id_comunidad AND h.tipo='matrimonio' AND h.ausente=0 ORDER BY h.nombre");
            $data = $query->getArrayResult();
        }
        
        return  new HttpFoundation\JsonResponse($data);
 
    }
    
    public function getSolterosAction($codigo)
    {
        $comunidadRepository = $this->getDoctrine()->getRepository('CHCGruposBundle:Comunidad');
        $comunidad = $comunidadRepository->findOneByCodigo($codigo);
        
        $data = array();
        if($comunidad instanceof Entity\Comunidad){
            $id_comunidad = $comunidad->getId();
            $em = $this->getDoctrine()->getEntityManager();
            $query = $em->createQuery("SELECT h.id, h.nombre FROM CHCGruposBundle:Hermano h where h.comunidad=$id_comunidad AND h.tipo='soltero' AND h.ausente=0 ORDER BY h.nombre");
            $data = $query->getArrayResult();
        }
        
        return  new HttpFoundation\JsonResponse($data);
 
    }
    
    public function getAusentesAction($codigo)
    {
        $comunidadRepository = $this->getDoctrine()->getRepository('CHCGruposBundle:Comunidad');
        $comunidad = $comunidadRepository->findOneByCodigo($codigo);
        
        $data = array();
        if($comunidad instanceof Entity\Comunidad){
            $id_comunidad = $comunidad->getId();
            $em = $this->getDoctrine()->getEntityManager();
            $query = $em->createQuery("SELECT h.id, h.nombre FROM CHCGruposBundle:Hermano h where h.comunidad=$id_comunidad AND h.ausente=1 ORDER BY h.nombre");
            $data = $query->getArrayResult();
        }
        
        return  new HttpFoundation\JsonResponse($data);
 
    }
    
    public function postMatrimoniosAction($codigo)
    {
        
        //$data = json_decode($this->get("request")->getContent(), true);
        //$nombre = $data['nombre'];
        $request = $this->getRequest();
        $nombre = $request->get('nombre');
        
        $comunidadRepository = $this->getDoctrine()->getRepository('CHCGruposBundle:Comunidad');
        $comunidad = $comunidadRepository->findOneByCodigo($codigo);
        
        if(!empty($nombre)){
            $matrimonio = new Entity\Hermano();
            $matrimonio->setComunidad($comunidad);
            $matrimonio->setTipo('matrimonio');
            $matrimonio->setNombre($nombre);
            $matrimonio->setAusente(0);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($matrimonio);
            $em->flush();
        }

        return  new HttpFoundation\JsonResponse(array('id'=>$matrimonio->getId(),'nombre'=>$matrimonio->getNombre()));

    }
    
    public function postSolterosAction($codigo)
    {
        $request = $this->getRequest();
        $nombre = $request->get('nombre');
        
        $comunidadRepository = $this->getDoctrine()->getRepository('CHCGruposBundle:Comunidad');
        $comunidad = $comunidadRepository->findOneByCodigo($codigo);
        
        if(!empty($nombre)){
            $soltero = new Entity\Hermano();
            $soltero->setComunidad($comunidad);
            $soltero->setTipo('soltero');
            $soltero->setNombre($nombre);
            $soltero->setAusente(0);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($soltero);
            $em->flush();
        }

        return  new HttpFoundation\JsonResponse(array('id'=>$soltero->getId(),'nombre'=>$soltero->getNombre()));

    }
    
//    public function postAusentesAction($codigo)
//    {
//        $data = json_decode($this->get("request")->getContent(), true);
//        $nombre = $data['nombre'];
//        
//        $comunidadRepository = $this->getDoctrine()->getRepository('CHCGruposBundle:Comunidad');
//        $comunidad = $comunidadRepository->findOneByCodigo($codigo);
//        
//        if(!empty($nombre)){
//            $ausente = new Entity\Hermano();
//            $ausente->setComunidad($comunidad);
//            $ausente->setTipo('ausente');
//            $ausente->setNombre($nombre);
//            
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($ausente);
//            $em->flush();
//        }
//
//        return new HttpFoundation\JsonResponse(array('id'=>$ausente->getId(),'nombre'=>$ausente->getNombre()));
// 
//    }
    
    public function deleteHermanosAction($codigo,$id)
    {
        $comunidadRepository = $this->getDoctrine()->getRepository('CHCGruposBundle:Comunidad');
        $comunidad = $comunidadRepository->findOneByCodigo($codigo);
        
        $hermanoRepository = $this->getDoctrine()->getRepository('CHCGruposBundle:Hermano');
        $hermano = $hermanoRepository->find($id);
        
        if($hermano instanceof Entity\Hermano && $comunidad instanceof Entity\Comunidad){
            if($hermano->getComunidad()->getId() === $comunidad->getId()){
                $em = $this->getDoctrine()->getManager();
                $em->remove($hermano);
                $em->flush();
            }
        }

        return  new HttpFoundation\JsonResponse(array('deleted'));

    }
    
    public function putHermanosAction($codigo,$id)
    {
        $request = $this->getRequest();
        $ausente = $request->get('ausente');
        $nombre = $request->get('nombre');
        
        $comunidadRepository = $this->getDoctrine()->getRepository('CHCGruposBundle:Comunidad');
        $comunidad = $comunidadRepository->findOneByCodigo($codigo);
        
        $hermanoRepository = $this->getDoctrine()->getRepository('CHCGruposBundle:Hermano');
        $hermano = $hermanoRepository->find($id);
        
        if($hermano instanceof Entity\Hermano && $comunidad instanceof Entity\Comunidad){
            if($hermano->getComunidad()->getId() === $comunidad->getId()){
                if(!is_null($ausente) || !is_null($nombre)){
                    if(!is_null($ausente)) {$hermano->setAusente($ausente);}
                    if(!is_null($nombre)) {$hermano->setNombre($nombre);}
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($hermano);
                    $em->flush();
                }
                
            }
        }

        return  new HttpFoundation\JsonResponse(array('id'=>$hermano->getId(),'nombre'=>$hermano->getNombre(),'tipo'=>$hermano->getTipo()));

    }
    
    
     /**
     * Añade a la respuesta los headers necesarios para permitir
     * cross site http requests
     *
     * @param Response $response
     */
    protected function setCORSHeaders(HttpFoundation\Response $response){
        

        return $response;
    }
    
}
