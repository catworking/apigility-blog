<?php
namespace ApigilityBlog\V1\Rest\Category;

use ApigilityBlog\DoctrineEntity\Category;
use ApigilityCatworkFoundation\Base\ApigilityObjectStorageAwareEntity;
use ApigilityUser\DoctrineEntity\User;
use ApigilityUser\V1\Rest\User\UserEntity;
use Zend\Hydrator\ClassMethods as ClassMethodsHydrator;

class CategoryEntity extends ApigilityObjectStorageAwareEntity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * 分类名称
     *
     * @Column(type="string", length=50, nullable=false)
     */
    protected $name;

    /**
     * @OneToMany(targetEntity="Category", mappedBy="parent")
     */
    protected $children;

    /**
     * @ManyToOne(targetEntity="Category", inversedBy="children")
     * @JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $parent;

    /**
     * 分类的所有者，ApigilityUser组件的User对象
     *
     * @ManyToOne(targetEntity="ApigilityUser\DoctrineEntity\User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

    public function getParent()
    {
        if ($this->parent instanceof Category) return $this->hydrator->extract(new CategoryEntity($this->parent, $this->serviceManager));
        else return $this->parent;
    }

    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    public function getUser()
    {
        if ($this->user instanceof User) return $this->hydrator->extract(new UserEntity($this->user, $this->serviceManager));
        else return $this->user;
    }
}
