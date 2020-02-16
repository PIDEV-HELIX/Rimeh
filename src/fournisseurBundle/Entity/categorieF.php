<?php

namespace fournisseurBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * categorieF
 *
 * @ORM\Table(name="categorie_f")
 * @ORM\Entity(repositoryClass="fournisseurBundle\Repository\categorieFRepository")
 */
class categorieF
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nomC", type="string", length=255)
     */
    private $nomC;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nomC
     *
     * @param string $nomC
     *
     * @return categorieF
     */
    public function setNomC($nomC)
    {
        $this->nomC = $nomC;

        return $this;
    }

    /**
     * Get nomC
     *
     * @return string
     */
    public function getNomC()
    {
        return $this->nomC;
    }

}

