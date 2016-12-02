<?php
namespace ApigilityBlog\V1\Rest\Media;

use Zend\Hydrator\ClassMethods as ClassMethodsHydrator;

class MediaEntity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @Column(type="smallint", nullable=false)
     */
    protected $type;

    /**
     * 分类名称
     *
     * @Column(type="string", length=50, nullable=true)
     */
    protected $title;

    /**
     * @Column(type="string", length=255, nullable=false)
     */
    protected $uri;

    /**
     * 创建时间
     *
     * @Column(type="datetime", nullable=false)
     */
    protected $create_time;

    private $hy;

    public function __construct(\ApigilityBlog\DoctrineEntity\Media $media)
    {
        $this->hy = new ClassMethodsHydrator();
        $this->hy->hydrate($this->hy->extract($media), $this);
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

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function getType()
    {
        return $this->type;
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

    public function setUri($uri)
    {
        $this->uri = $uri;
        return $this;
    }

    public function getUri()
    {
        return $this->uri;
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
}
