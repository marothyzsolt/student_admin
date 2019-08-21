<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StudentRepository")
 */
class Student extends BaseEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank(message="The name should not be blank.")
     * @Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Type("\DateTime")
     */
    private $birth_date;

    /**
     * @ORM\Column(type="string", nullable=false, options={"unsigned":true})
     * @Assert\NotBlank(message="The email should not be blank.")
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default":1})
     */
    private $sex;

    /**
     * @ORM\OneToMany(targetEntity="StudyGroup", mappedBy="leader")
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
     * @ORM\ManyToMany(targetEntity="StudyGroup", mappedBy="students")
     */
    private $groups;

    public function __construct()
    {
        $this->leadGroups = new ArrayCollection();
        $this->groups = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birth_date;
    }

    public function setBirthDate(?\DateTimeInterface $birth_date): self
    {
        $this->birth_date = $birth_date;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSex(): ?bool
    {
        return $this->sex;
    }

    public function setSex(bool $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * @return Collection|StudyGroup[]
     */
    public function getLeadGroups(): Collection
    {
        return $this->leadGroups;
    }

    public function addLeadGroup(StudyGroup $leadGroup): self
    {
        if (!$this->leadGroups->contains($leadGroup)) {
            $this->leadGroups[] = $leadGroup;
            $leadGroup->setLeader($this);
        }

        return $this;
    }

    public function removeLeadGroup(StudyGroup $leadGroup): self
    {
        if ($this->leadGroups->contains($leadGroup)) {
            $this->leadGroups->removeElement($leadGroup);
            // set the owning side to null (unless already changed)
            if ($leadGroup->getLeader() === $this) {
                $leadGroup->setLeader(null);
            }
        }

        return $this;
    }

    public function getTown(): ?Town
    {
        return $this->town;
    }

    public function setTown(?Town $town): self
    {
        $this->town = $town;

        return $this;
    }

    public function getProfileImage(): ?Image
    {
        return $this->profileImage;
    }

    public function setProfileImage(?Image $profileImage): self
    {
        $this->profileImage = $profileImage;

        return $this;
    }

    /**
     * @return Collection|StudyGroup[]
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(StudyGroup $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
            $group->addStudent($this);
        }

        return $this;
    }

    public function removeGroup(StudyGroup $group): self
    {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);
            $group->removeStudent($this);
        }

        return $this;
    }



}