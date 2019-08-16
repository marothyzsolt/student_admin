<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Group
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
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="leadGroups")
     * @ORM\JoinColumn(name="leader_student_id", referencedColumnName="id")
     */
    private $leader;

    /**
     * @ORM\ManyToOne(targetEntity="Subject", inversedBy="groups")
     * @ORM\JoinColumn(name="subject_id", referencedColumnName="id", nullable=false)
     */
    private $subject;

    /**
     * @ORM\ManyToMany(targetEntity="Student", inversedBy="groups")
     * @ORM\JoinTable(
     *     name="group_student",
     *     joinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id", nullable=false)},
     *     inverseJoinColumns={@ORM\JoinColumn(name="student_id", referencedColumnName="id", nullable=false)}
     * )
     */
    private $students;
}