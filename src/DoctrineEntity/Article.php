<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/1
 * Time: 19:41
 */
namespace ApigilityBlog\DoctrineEntity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Common\Collections\ArrayCollection;
use ApigilityUser\DoctrineEntity\User;

/**
 * Class Article
 * @package ApigilityBlog\DoctrineEntity
 * @Entity @Table(name="apigilityblog_article")
 */
class Article
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

    public function __construct() {
        $this->medias = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

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

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function addMedia(Media $media)
    {
        $this->medias[] = $media;
        return $this;
    }

    public function getMedias()
    {
        return $this->medias;
    }

    public function addCategory($category)
    {
        $this->categories[] = $category;
        return $this;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function setCreateTime(\DateTime $create_time)
    {
        $this->create_time = $create_time;
        return $this;
    }

    public function getCreateTime()
    {
        return $this->create_time;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }
}