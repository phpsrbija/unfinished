<?php

namespace Admin\Model\Entity;

use Zend\Stdlib\ArraySerializableInterface;

/**
 * Class ArticleEntity.
 *
 * @package Admin\Model\Entity
 */
class ArticleEntity implements ArraySerializableInterface
{
    const TYPE_STANDARD = 1;

    const STATUS_UNPUBLISHED = 0;
    const STATUS_PUBLISHED = 1;

    /**
     * @var string
     */
    private $article_uuid;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $body;

    /**
     * @var string
     */
    private $lead;

    /**
     * @var integer
     */
    private $type = self::TYPE_STANDARD;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $published_at;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $user_uuid = 1;

    /**
     * @inheritdoc
     *
     * @param array $array
     */
    public function exchangeArray(array $array)
    {
        foreach ($array as $key => $value) {
            $setter = 'set' . ucfirst($key);

            if (method_exists($this, $setter)) {
                $this->{$setter}($value);
            }
        }
    }

    /**
     * @inheritdoc
     *
     * @return array
     */
    public function getArrayCopy()
    {
        $data = [];

        foreach (get_object_vars($this) as $key => $value) {
            $data[$key] = $value;
        }

        return $data;
    }

    /**
     * @return string
     */
    public function getArticle_uuid()
    {
        return bin2hex($this->article_uuid);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getLead()
    {
        return $this->lead;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return \DateTime
     */
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * @return \DateTime
     */
    public function getPublished_at()
    {
        return $this->published_at;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getUser_uuid()
    {
        return $this->user_uuid;
    }

    /**
     * @param string $articleUuid
     */
    private function setArticle_uuid($articleUuid)
    {
        $this->article_uuid = $articleUuid;
    }

    /**
     * @param string $title
     */
    private function setTitle($title)
    {
        $this->title = $title;
        $this->setSlug($title);
    }

    /**
     * @param string $slug
     */
    private function setSlug($slug)
    {
        $this->slug = urlencode($slug);
    }

    /**
     * @param string $body
     */
    private function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @param string $lead
     */
    private function setLead($lead)
    {
        $this->lead = $lead;
    }

    /**
     * @param int $type
     */
    private function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param \DateTime $createdAt
     */
    private function setCreated_at($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * @param \DateTime $publishedAt
     */
    private function setPublished_at($publishedAt)
    {
        $this->published_at = $publishedAt;
    }

    /**
     * @param int $status
     */
    private function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @param int $userUuid
     */
    private function setUser_uuid($userUuid)
    {
        $this->user_uuid = $userUuid;
    }
}
