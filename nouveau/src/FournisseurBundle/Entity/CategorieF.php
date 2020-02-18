<?php

namespace FournisseurBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategorieF
 *
 * @ORM\Table(name="categorief")
 * @ORM\Entity(repositoryClass="FournisseurBundle\Repository\CategorieFRepository")
 */

class CategorieF
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
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


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