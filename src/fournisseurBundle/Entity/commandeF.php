<?php

namespace fournisseurBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * commandeF
 *
 * @ORM\Table(name="commande_f")
 * @ORM\Entity(repositoryClass="fournisseurBundle\Repository\commandeFRepository")
 */
class commandeF
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
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=255)
     */
    private $date;


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
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return commandeF
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set date
     *
     * @param string $date
     *
     * @return commandeF
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getSociete()
    {
        return $this->Societe;
    }

    /**
     * @param mixed $Societe
     */
    public function setSociete($Societe)
    {
        $this->Societe = $Societe;
    }
    /**
     * @ORM\ManyToOne(targetEntity="Societe")
     * @ORM\JoinColumn(name="societe_id",referencedColumnName="id")
     */

    private $Societe;
}

