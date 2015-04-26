<?php

namespace CHC\GruposBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hermano
 *
 * @ORM\Table(name="hermano")
 * @ORM\Entity
 */
class Hermano
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
     * @var \CHC\GruposBundle\Entity\Comunidad
     *
     * @ORM\ManyToOne(targetEntity="CHC\GruposBundle\Entity\Comunidad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_comunidad", referencedColumnName="id")
     * })
     */
    private $comunidad;
    
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
     * @var boolean
     *
     * @ORM\Column(name="ausente", type="boolean")
     */
    private $ausente;

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Hermano
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
     * @return Hermano
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
     * @return Hermano
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
     * Set comunidad
     *
     * @param \CHC\GruposBundle\Entity\Comunidad $comunidad
     * @return Hermano
     */
    public function setComunidad(\CHC\GruposBundle\Entity\Comunidad $comunidad = null)
    {
        $this->comunidad = $comunidad;

        return $this;
    }

    /**
     * Get comunidad
     *
     * @return \CHC\GruposBundle\Entity\Comunidad 
     */
    public function getComunidad()
    {
        return $this->comunidad;
    }
    
    /**
     * Set ausente
     *
     * @param boolean $ausente
     * @return Hermano
     */
    public function setAusente($ausente)
    {
        $this->ausente = $ausente;

        return $this;
    }

    /**
     * Get ausente
     *
     * @return boolean 
     */
    public function getAusente()
    {
        return $this->ausente;
    }
    
}
