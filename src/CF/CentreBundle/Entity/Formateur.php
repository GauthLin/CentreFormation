<?php

namespace CF\CentreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Asset;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Formateur
 *
 * @ORM\Table(name="formateur")
 * @ORM\Entity(repositoryClass="CF\CentreBundle\Entity\FormateurRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Formateur
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
     * @Asset\Length(min=2, minMessage="Le nom doit contenir au moins 2 caractères.")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     * @Asset\Length(min=2, minMessage="Le prénom doit contenir au moins 2 caractères.")
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="gsm", type="string", length=255)
     * @Asset\Regex(pattern="/^[0-9]{10}$/", match=true, message="Votre numéro de GSM doit contenir 10 chiffres.")
     */
    private $gsm;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Asset\Email(message="{{ value }} n'est pas une adresse mail valide.")
     */
    private $email;

    // Slug
    /**
     * @Gedmo\Slug(fields={"prenom", "nom"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="CF\CentreBundle\Entity\Formation", mappedBy="formateur")
     */
    private $formations;

    // Retourne le nom complet du formateur
    public function getNomComplet()
    {
        return $this->nom.' '.$this->prenom;
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
     * @return Formateur
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
     * Set prenom
     *
     * @param string $prenom
     * @return Formateur
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set gsm
     *
     * @param string $gsm
     * @return Formateur
     */
    public function setGsm($gsm)
    {
        $this->gsm = $gsm;

        return $this;
    }

    /**
     * Get gsm
     *
     * @return string 
     */
    public function getGsm()
    {
        return $this->gsm;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Formateur
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Formateur
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->formations = new ArrayCollection();
    }

    /**
     * Add formations
     *
     * @param \CF\CentreBundle\Entity\Formation $formation
     * @return Formateur
     */
    public function addFormation(Formation $formation)
    {
        $this->formations[] = $formation;

        return $this;
    }

    /**
     * Remove formations
     *
     * @param \CF\CentreBundle\Entity\Formation $formation
     */
    public function removeFormation(Formation $formation)
    {
        $this->formations->removeElement($formation);

        $formation->setFormateur(null);
    }

    /**
     * Get formations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFormations()
    {
        return $this->formations;
    }

    /**
     * @ORM\PreRemove()
     */
    public function delFormation()
    {
        foreach($this->formations as $value)
            $this->removeFormation($value);
    }
}
