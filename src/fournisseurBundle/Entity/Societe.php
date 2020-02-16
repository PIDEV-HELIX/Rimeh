<?php

namespace fournisseurBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Societe
 *
 * @ORM\Table(name="societe")
 * @ORM\Entity(repositoryClass="fournisseurBundle\Repository\SocieteRepository")
 */
class Societe
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
     * @ORM\Column(name="nameS", type="string", length=255)
     */
    private $nameS;

    /**
     * @var string
     *
     * @ORM\Column(name="Addresse", type="string", length=255)
     */
    private $Addresse;

    /**
     * @return string
     */
    public function getAddresse()
    {
        return $this->Addresse;
    }

    /**
     * @param string $Addresse
     */
    public function setAddresse($Addresse)
    {
        $this->Addresse = $Addresse;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;
    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=255)
     */
    private $telephone;

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
     * Set nameS
     *
     * @param string $nameS
     *
     * @return Societe
     */
    public function setNameS($nameS)
    {
        $this->nameS = $nameS;

        return $this;
    }

    /**
     * Get nameS
     *
     * @return string
     */
    public function getNameS()
    {
        return $this->nameS;
    }
    /**
     * @ORM\ManyToOne(targetEntity="categorieF")
     * @ORM\JoinColumn(name="categorie_id",referencedColumnName="id")
     */

    public $categorieF;

    /**
     * @return mixed
     */
    public function getCategorieF()
    {
        return $this->categorieF;
    }

    /**
     * @param mixed $categorieF
     */
    public function setCategorieF($categorieF)
    {
        $this->categorieF = $categorieF;
    }

}

