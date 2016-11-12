<?php

namespace CF\CentreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Asset;

/**
 * Formation
 *
 * @ORM\Table(name="formation")
 * @ORM\Entity(repositoryClass="CF\CentreBundle\Entity\FormationRepository")
 */
class Formation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     * @Asset\NotBlank(message="Le nom de la formation ne peut pas être vide.")
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @Asset\DateTime()
     */
    private $date;

    /**
     * @var float
     *
     * @ORM\Column(name="duree", type="float")
     * @Asset\Type(type="float", message="La durée de la formation n'est pas un nombre valide.")
     */
    private $duree;

    // Slug
    /**
     * @Gedmo\Slug(fields={"nom"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="CF\CentreBundle\Entity\Formateur", inversedBy="formations")
     * @ORM\JoinColumn(nullable=true)
     */
    private $formateur;

    // Préremplissage de la date du jour
    public function __construct()
    {
        $this->date = new \DateTime();
    }

    public function setFormateur(Formateur $formateur = null)
    {
        $this->formateur = $formateur;

        if($formateur !== null)
            $this->formateur->addFormation($this);

        return $this;
    }

    public function getFormateur()
    {
        return $this->formateur;
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
     * Set nom
     *
     * @param string $nom
     * @return Formation
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Formation
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set duree
     *
     * @param float $duree
     * @return Formation
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree
     *
     * @return float 
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Formation
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
