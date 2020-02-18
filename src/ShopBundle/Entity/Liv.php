<?php

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Liv
 *
 * @ORM\Table(name="liv")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\LivRepository")
 */
class Liv
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateliv", type="datetime")
     */
    private $dateliv;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_street", type="string", length=255)
     */
    private $adresseStreet;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255)
     */
    private $ville;

    /**
     * @var int
     *
     * @ORM\Column(name="codeP", type="integer")
     */
    private $codeP;

    /**
     * @var string
     *
     * @ORM\Column(name="modeliv", type="string", length=255)
     */
    private $modeliv;


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
     * Set dateliv
     *
     * @param \DateTime $dateliv
     *
     * @return Liv
     */
    public function setDateliv($dateliv)
    {
        $this->dateliv = $dateliv;

        return $this;
    }

    /**
     * Get dateliv
     *
     * @return \DateTime
     */
    public function getDateliv()
    {
        return $this->dateliv;
    }

    /**
     * Set adresseStreet
     *
     * @param string $adresseStreet
     *
     * @return Liv
     */
    public function setAdresseStreet($adresseStreet)
    {
        $this->adresseStreet = $adresseStreet;

        return $this;
    }

    /**
     * Get adresseStreet
     *
     * @return string
     */
    public function getAdresseStreet()
    {
        return $this->adresseStreet;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Liv
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Liv
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set codeP
     *
     * @param integer $codeP
     *
     * @return Liv
     */
    public function setCodeP($codeP)
    {
        $this->codeP = $codeP;

        return $this;
    }

    /**
     * Get codeP
     *
     * @return int
     */
    public function getCodeP()
    {
        return $this->codeP;
    }

    /**
     * Set modeliv
     *
     * @param string $modeliv
     *
     * @return Liv
     */
    public function setModeliv($modeliv)
    {
        $this->modeliv = $modeliv;

        return $this;
    }

    /**
     * Get modeliv
     *
     * @return string
     */
    public function getModeliv()
    {
        return $this->modeliv;
    }
}

