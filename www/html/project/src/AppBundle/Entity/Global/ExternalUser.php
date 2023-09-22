<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="external_users", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="unq_content_external_user", columns={"email"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExternalUserRepository")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE", region="my_external_user_region_result")
 */
class ExternalUser extends BetradarEntity {

    const EXISTANCE_CHECK_FIELD = 'Name';
     
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
     * @Assert\NotBlank(message="Inserire il nome")
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     * @Assert\NotBlank(message="Inserire il cognome")
     * @ORM\Column(name="surname", type="string", length=255, nullable=true)
     */
    private $surname;
    
    /**
     * @var string
     * @Assert\NotBlank(message="UserName obbligatorio")
     * @ORM\Column(name="username", type="string", length=255, nullable=true)
     */
    private $username;
    
    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;
    
    /**
     * @var string
     * @Assert\NotBlank(message="Inserire una password")
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var int
     * 
     * @ORM\Column(name="age", type="integer", nullable=true)
     */
    private $age;

    /**
     * @ORM\Column(name="subcategory_id", type="integer", nullable=true)
     */
    private $team;
    
    /**
     * @var datetime
     *
     * @ORM\Column(name="register_at", type="datetime")
     */
    private $registerAt;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="ext_user_code", type="string", length=255, nullable=true)
     */
    private $extUserCode;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="access_token", type="string", length=255, nullable=true)
     */
    private $accessToken;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="profile_img", type="string", length=255, nullable=true)
     */
    private $profileImg;
    
    /**
     * @var boolean
     * @ORM\Column(name="is_top_user", type="boolean", nullable=true, options={"default" = 0})
     */
    private $isTopUser;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="privacy", type="boolean", nullable=true, options={"default" = 0})
     */
    private $privacy;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="newsletters", type="boolean", nullable=true, options={"default" = 0})
     */
    private $newsletters;
    
    public function __construct() {
        $this->tournaments = new ArrayCollection();
        parent::__construct(self::EXISTANCE_CHECK_FIELD);
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
     * Set name
     *
     * @param string $name
     *
     * @return ExternalUser
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     * @return ExternalUser
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return ExternalUser
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
     * Set name
     *
     * @param string $username
     *
     * @return ExternalUser
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return ExternalUser
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return ExternalUser
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
     * Set age
     *
     * @param integer $age
     *
     * @return ExternalUser
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set team
     *
     * @param \AppBundle\Entity\Subcategory $team
     *
     * @return ExternalUser
     */
    public function setTeam( $team = null)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get team
     *
     * @return \AppBundle\Entity\Subcategory
     */
    public function getTeam()
    {
        return $this->team;
    }
    
    /**
     * Set createAt
     *
     * @param \DateTime $registerAt
     *
     * @return Comment
     */
    public function setRegisterAt($registerAt)
    {
        $this->registerAt = $registerAt;

        return $this;
    }

    /**
     * Get registerAt
     *
     * @return \DateTime
     */
    public function getRegisterAt()
    {
        return $this->registerAt;
    }
    
    /**
     * Set extUserCode
     *
     * @param string $extUserCode
     *
     * @return ExternalUser
     */
    public function setExtUserCode($extUserCode)
    {
        $this->extUserCode = $extUserCode;

        return $this;
    }

    /**
     * Get extUserCode
     *
     * @return string
     */
    public function getExtUserCode()
    {
        return $this->extUserCode;
    }
    
    /**
     * Set accessToken
     *
     * @param string $accessToken
     *
     * @return accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * Get accessToken
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }
    
    /**
     * Set profileImg
     *
     * @param string $profileImg
     *
     * @return profileImg
     */
    public function setProfileImg($profileImg)
    {
        $this->profileImg = $profileImg;

        return $this;
    }

    /**
     * Get profileImg
     *
     * @return string
     */
    public function getProfileImg()
    {
        return $this->profileImg;
    }
    
    /**
     * Set isTopUser
     *
     * @param boolean $isTopUser
     *
     * @return boolean
     */
    public function setIsTopUser($isTopUser)
    {
        $this->isTopUser = $isTopUser;

        return $this;
    }

    /**
     * Get isTopUser
     *
     * @return boolean
     */
    public function getIsTopUser()
    {
        return $this->isTopUser;
    }
    
    /**
     * Set privacy
     *
     * @param boolean privacy
     *
     * @return boolean
     */
    public function setPrivacy($privacy)
    {
        $this->privacy = $privacy;

        return $this;
    }

    /**
     * Get $privacy
     *
     * @return boolean
     */
    public function getPrivacy()
    {
        return $this->privacy;
    }
    
      /**
     * Set newsletters
     *
     * @param boolean newsletters
     *
     * @return boolean
     */
    public function setNewsletters($newsletters)
    {
        $this->newsletters = $newsletters;

        return $this;
    }

    /**
     * Get newsletters
     *
     * @return boolean
     */
    public function getNewsletters()
    {
        return $this->newsletters;
    }
}
