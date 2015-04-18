<?php

namespace CHC\GruposBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hermanos
 *
 * @ORM\Table(name="hermanos", indexes={@ORM\Index(name="id_comunidad", columns={"id_comunidad"})})
 * @ORM\Entity
 */
class Hermanos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=30, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=20, nullable=false)
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=20, nullable=true)
     */
    private $telefono;

    /**
     * @var \CHC\GruposBundle\Entity\Comunidad
     *
     * @ORM\ManyToOne(targetEntity="CHC\GruposBundle\Entity\Comunidad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_comunidad", referencedColumnName="id")
     * })
     */
    private $idComunidad;



    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Hermanos
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return Hermanos
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Hermanos
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idComunidad
     *
     * @param \CHC\GruposBundle\Entity\Comunidad $idComunidad
     * @return Hermanos
     */
    public function setIdComunidad(\CHC\GruposBundle\Entity\Comunidad $idComunidad = null)
    {
        $this->idComunidad = $idComunidad;

        return $this;
    }

    /**
     * Get idComunidad
     *
     * @return \CHC\GruposBundle\Entity\Comunidad 
     */
    public function getIdComunidad()
    {
        return $this->idComunidad;
    }
}
