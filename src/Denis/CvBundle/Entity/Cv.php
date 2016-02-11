<?php

namespace Denis\CvBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Denis\UserBundle\Entity\User;

/**
 * Cv
 *
 * @ORM\Table(name="cvs")
 * @ORM\Entity(repositoryClass="Denis\CvBundle\Entity\CvRepository")
 */
class Cv
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
     * @ORM\Column(name="cvName", type="string", length=255)
     */
    private $cvName;

    /**
     * @var string
     *
     * @ORM\Column(name="nameAndSurname", type="string", length=255)
     */
    private $nameAndSurname;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="cellPhone", type="string", length=255)
     */
    private $cellPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="dateOfBirth", type="string", length=255)
     */
    private $dateOfBirth;

    /**
     * @var string
     *
     * @ORM\Column(name="birthPlace", type="string", length=255)
     */
    private $birthPlace;

    /**
     * @var string
     *
     * @ORM\Column(name="workExpirience", type="text")
     */
    private $workExpirience;

    /**
     * @var string
     *
     * @ORM\Column(name="education", type="text")
     */
    private $education;

    /**
     * @var string
     *
     * @ORM\Column(name="foreignLanguages", type="string", length=255)
     */
    private $foreignLanguages;

    /**
     * @var string
     *
     * @ORM\Column(name="tehnicalCapabilities", type="text")
     */
    private $tehnicalCapabilities;

    /**
     * @var string
     *
     * @ORM\Column(name="drivingLicense", type="string", length=255)
     */
    private $drivingLicense;

    /**
     * @var string
     *
     * @ORM\Column(name="additionalInformation", type="text")
     */
    private $additionalInformation;

	/**
	 * @ORM\ManyToOne(targetEntity="Denis\UserBundle\Entity\User")
	 * @ORM\JoinColumn(onDelete="CASCADE")
	 */
	private $owner;	

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
     * Set cvName
     *
     * @param string $cvName
     * @return Cv
     */
    public function setCvName($cvName)
    {
        $this->cvName = $cvName;

        return $this;
    }

    /**
     * Get cvName
     *
     * @return string 
     */
    public function getCvName()
    {
        return $this->cvName;
    }

    /**
     * Set nameAndSurname
     *
     * @param string $nameAndSurname
     * @return Cv
     */
    public function setNameAndSurname($nameAndSurname)
    {
        $this->nameAndSurname = $nameAndSurname;

        return $this;
    }

    /**
     * Get nameAndSurname
     *
     * @return string 
     */
    public function getNameAndSurname()
    {
        return $this->nameAndSurname;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Cv
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
     * Set phone
     *
     * @param string $phone
     * @return Cv
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
     * Set cellPhone
     *
     * @param string $cellPhone
     * @return Cv
     */
    public function setCellPhone($cellPhone)
    {
        $this->cellPhone = $cellPhone;

        return $this;
    }

    /**
     * Get cellPhone
     *
     * @return string 
     */
    public function getCellPhone()
    {
        return $this->cellPhone;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Cv
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
     * Set dateOfBirth
     *
     * @param string $dateOfBirth
     * @return Cv
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth
     *
     * @return string 
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Set birthPlace
     *
     * @param string $birthPlace
     * @return Cv
     */
    public function setBirthPlace($birthPlace)
    {
        $this->birthPlace = $birthPlace;

        return $this;
    }

    /**
     * Get birthPlace
     *
     * @return string 
     */
    public function getBirthPlace()
    {
        return $this->birthPlace;
    }

    /**
     * Set workExpirience
     *
     * @param string $workExpirience
     * @return Cv
     */
    public function setWorkExpirience($workExpirience)
    {
        $this->workExpirience = $workExpirience;

        return $this;
    }

    /**
     * Get workExpirience
     *
     * @return string 
     */
    public function getWorkExpirience()
    {
        return $this->workExpirience;
    }

    /**
     * Set education
     *
     * @param string $education
     * @return Cv
     */
    public function setEducation($education)
    {
        $this->education = $education;

        return $this;
    }

    /**
     * Get education
     *
     * @return string 
     */
    public function getEducation()
    {
        return $this->education;
    }

    /**
     * Set foreignLanguages
     *
     * @param string $foreignLanguages
     * @return Cv
     */
    public function setForeignLanguages($foreignLanguages)
    {
        $this->foreignLanguages = $foreignLanguages;

        return $this;
    }

    /**
     * Get foreignLanguages
     *
     * @return string 
     */
    public function getForeignLanguages()
    {
        return $this->foreignLanguages;
    }

    /**
     * Set tehnicalCapabilities
     *
     * @param string $tehnicalCapabilities
     * @return Cv
     */
    public function setTehnicalCapabilities($tehnicalCapabilities)
    {
        $this->tehnicalCapabilities = $tehnicalCapabilities;

        return $this;
    }

    /**
     * Get tehnicalCapabilities
     *
     * @return string 
     */
    public function getTehnicalCapabilities()
    {
        return $this->tehnicalCapabilities;
    }

    /**
     * Set drivingLicense
     *
     * @param string $drivingLicense
     * @return Cv
     */
    public function setDrivingLicense($drivingLicense)
    {
        $this->drivingLicense = $drivingLicense;

        return $this;
    }

    /**
     * Get drivingLicense
     *
     * @return string 
     */
    public function getDrivingLicense()
    {
        return $this->drivingLicense;
    }

    /**
     * Set additionalInformation
     *
     * @param string $additionalInformation
     * @return Cv
     */
    public function setAdditionalInformation($additionalInformation)
    {
        $this->additionalInformation = $additionalInformation;

        return $this;
    }

    /**
     * Get additionalInformation
     *
     * @return string 
     */
    public function getAdditionalInformation()
    {
        return $this->additionalInformation;
    }

    /**
     * Set owner
     *
     * @param \Denis\UserBundle\Entity\User $owner
     * @return Cv
     */
    public function setOwner(\Denis\UserBundle\Entity\User $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \Denis\UserBundle\Entity\User 
     */
    public function getOwner()
    {
        return $this->owner;
    }
}
