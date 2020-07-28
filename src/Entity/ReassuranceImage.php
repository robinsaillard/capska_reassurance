<?php
declare(strict_types=1);

namespace Capska\CapskaReassurance\Entity;
use Doctrine\ORM\Mapping as ORM;

class ReassuranceImage
{

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id_image", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id; 


    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $imageName;



    /**
     * Get the value of id
     *
     * @return  int
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param  int  $id
     *
     * @return  self
     */ 
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of imageName
     *
     * @return  string
     */ 
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Set the value of imageName
     *
     * @param  string  $imageName
     *
     * @return  self
     */ 
    public function setImageName(string $imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }
}