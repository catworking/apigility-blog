<?php
namespace ApigilityBlog\V1\Rest\Article;

use ApigilityBlog\V1\Rest\Category\CategoryEntity;
use ApigilityBlog\V1\Rest\Media\MediaEntity;
use ApigilityUser\DoctrineEntity\User;
use ApigilityUser\V1\Rest\User\UserEntity;
use Zend\Hydrator\ClassMethods as ClassMethodsHydrator;

class ArticleEntity
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

    private $hy;

    public function __construct(\ApigilityBlog\DoctrineEntity\Article $article)
    {
        $this->hy = new ClassMethodsHydrator();
        $this->hy->hydrate($this->hy->extract($article), $this);
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

    public function setMedias($medias)
    {
        $this->medias = $medias;
    }

    public function getMedias()
    {
        $data = array();
        foreach ($this->medias as $media) {
            $data[] = $this->hy->extract(new MediaEntity($media));
        }

        return $data;
    }

    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    public function getCategories()
    {
        $data = array();
        foreach ($this->categories as $category) {
            $data[] = $this->hy->extract(new CategoryEntity($category));
        }

        return $data;
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
        if ($this->user instanceof User) return $this->hy->extract(new UserEntity($this->user));
        else return $this->user;
    }
}
