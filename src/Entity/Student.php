<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Student
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birth_date;

    /**
     * @ORM\Column(type="string", nullable=false, options={"unsigned":true})
     */
    private $email;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default":1})
     */
    private $sex;

    /**
     * @ORM\OneToMany(targetEntity="Group", mappedBy="leader")
     */
    private $leadGroups;

    /**
     * @ORM\ManyToOne(targetEntity="Town", inversedBy="students")
     * @ORM\JoinColumn(name="town_id", referencedColumnName="id")
     */
    private $town;

    /**
     * @ORM\ManyToOne(targetEntity="Image")
     * @ORM\JoinColumn(name="profile_image_id", referencedColumnName="id")
     */
    private $profileImage;

    /**
     * @ORM\ManyToMany(targetEntity="Group", mappedBy="students")
     */
    private $groups;
}