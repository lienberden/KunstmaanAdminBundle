<?php

namespace Kunstmaan\AdminBundle\Entity;

use FOS\UserBundle\Model\GroupInterface;
use FOS\UserBundle\Entity\User as BaseUser;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User entity
 *
 * @ORM\Entity(repositoryClass="Kunstmaan\AdminBundle\Repository\UserRepository")
 * @ORM\Table(name="kuma_users")
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
     * @ORM\ManyToMany(targetEntity="Kunstmaan\AdminBundle\Entity\Group")
     * @ORM\JoinTable(name="kuma_users_groups",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;

    /**
     * Construct a new user
     */
    public function __construct()
    {
        parent::__construct();
        $this->groups = new ArrayCollection();
    }

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
     * Set id
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Gets the groupIds for the user.
     *
     * @return array
     */
    public function getGroupIds()
    {
        $groups = $this->groups;

        $groupIds = array();
        if (count($groups) > 0) {
            /* @var $group GroupInterface */
            foreach ($groups as $group) {
                $groupIds[] = $group->getId();
            }
        }

        return $groupIds;
    }

    /**
     * Gets the groups the user belongs to.
     *
     * @return ArrayCollection
     */
    public function getGroups()
    {
        return $this->groups;
    }

}
