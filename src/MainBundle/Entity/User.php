<?php

namespace MainBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Vul uw voornaam in.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="Uw voornaam is te kort.",
     *     maxMessage="Uw voornaam is te lang.",
     *     groups={"Registration", "Profile"}
     *  )
     */
    protected $firstname ;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Vul uw achternaam in.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="Uw achternaam is te kort.",
     *     maxMessage="Uw achternaam is te lang.",
     *     groups={"Registration", "Profile"}
     *  )
     */
    protected $lastname ;

    /**
     * @ORM\Column(type="string", length=5)
     *
     * @Assert\NotBlank(message="Selecteer uw geslacht.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=5,
     *     groups={"Registration", "Profile"}
     *  )
     */
    protected $gender ;

    /**
     * @ORM\Column(type="date")
     *
     * @Assert\NotBlank(message="Vul uw geboortedatum in.", groups={"Registration", "Profile"})
     *
     */
    protected $birthdate;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Vul uw adresgegevens in.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     groups={"Registration", "Profile"}
     *  )
     */
    protected $address;

    /**
     * @ORM\Column(type="string", length=10)
     *
     * @Assert\NotBlank(message="Vul uw postcode in.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=6,
     *     max=7,
     *     groups={"Registration", "Profile"}
     *  )
     */
    protected $postal;

    /**
     * @ORM\Column(type="string", length=55)
     *
     * @Assert\NotBlank(message="Vul uw woonplaats in.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=55,
     *     groups={"Registration", "Profile"}
     *  )
     */
    protected $city;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Vul uw telefoonnummer in.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=8,
     *     max=12,
     *     groups={"Registration", "Profile"}
     *  )
     */
    protected $phone;

    /**
     * @ORM\Column(type="string", length=55)
     *
     * @Assert\NotBlank(message="Vul uw bankrekening in.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=25,
     *     groups={"Registration", "Profile"}
     *  )
     */
    protected $bankaccount;

    /**
     * @ORM\OneToMany(targetEntity="MainBundle\Entity\Answer", mappedBy="user")
     */
    protected $answer;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     *
     * @return User
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set postal
     *
     * @param string $postal
     *
     * @return User
     */
    public function setPostal($postal)
    {
        $this->postal = $postal;

        return $this;
    }

    /**
     * Get postal
     *
     * @return string
     */
    public function getPostal()
    {
        return $this->postal;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return User
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
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set bankaccount
     *
     * @param string $bankaccount
     *
     * @return User
     */
    public function setBankaccount($bankaccount)
    {
        $this->bankaccount = $bankaccount;

        return $this;
    }

    /**
     * Get bankaccount
     *
     * @return string
     */
    public function getBankaccount()
    {
        return $this->bankaccount;
    }

    /**
     * Add answer
     *
     * @param \MainBundle\Entity\Answer $answer
     *
     * @return User
     */
    public function addAnswer(Answer $answer)
    {
        $this->answer[] = $answer;

        return $this;
    }

    /**
     * Remove answer
     *
     * @param \MainBundle\Entity\Answer $answer
     */
    public function removeAnswer(Answer $answer)
    {
        $this->answer->removeElement($answer);
    }

    /**
     * Get answer
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAnswer()
    {
        return $this->answer;
    }
}
