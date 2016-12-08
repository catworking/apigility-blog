<?php
namespace ApigilityBlog\V1\Rest\Article;

use ApigilityBlog\V1\Rest\Category\CategoryEntity;
use ApigilityBlog\V1\Rest\Media\MediaEntity;
use ApigilityCatworkFoundation\Base\ApigilityObjectStorageAwareEntity;
use ApigilityUser\DoctrineEntity\User;
use ApigilityUser\V1\Rest\User\UserEntity;
use Zend\Hydrator\ClassMethods as ClassMethodsHydrator;

class ArticleEntity extends ApigilityObjectStorageAwareEntity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * 文章标题
     *
     * @Column(type="string", length=200, nullable=true)
     */
    protected $title;

    /**
     * 文章简介
     *
     * @Column(type="string", length=800, nullable=true)
     */
    protected $summary;

    /**
     * @Column(type="text", nullable=true)
     */
    protected $content;

    /**
     * 文章附加的媒体文件
     *
     * @ManyToMany(targetEntity="Media", inversedBy="articles")
     * @JoinTable(name="apigilityblog_articles_attaches_medias")
     */
    protected $medias;

    /**
     * 文章所属于的分类（可多选）
     *
     * @ManyToMany(targetEntity="Category", inversedBy="articles")
     * @JoinTable(name="apigilityblog_articles_belongs_categories")
     */
    protected $categories;

    /**
     * 创建时间
     *
     * @Column(type="datetime", nullable=false)
     */
    protected $create_time;

    /**
     * 文章的所有者，ApigilityUser组件的User对象
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

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setSummary($summary)
    {
        $this->summary = $summary;
        return $this;
    }

    public function getSummary()
    {
        return $this->summary;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setMedias($medias)
    {
        $this->medias = $medias;
    }

    public function getMedias()
    {
        return $this->getJsonValueFromDoctrineCollection($this->medias, MediaEntity::class, $this->serviceManager);
    }

    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    public function getCategories()
    {
        return $this->getJsonValueFromDoctrineCollection($this->categories, CategoryEntity::class, $this->serviceManager);
    }

    public function setCreateTime(\DateTime $create_time)
    {
        $this->create_time = $create_time->getTimestamp();
        return $this;
    }

    public function getCreateTime()
    {
        return $this->create_time;
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
