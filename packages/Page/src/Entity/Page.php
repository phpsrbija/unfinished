<?php

namespace Page\Entity;

class Page
{
    private $page_uuid;
    private $page_id;
    private $title;
    private $body;
    private $description;
    private $main_img;
    private $has_layout;
    private $is_homepage;
    private $is_active;
    private $created_at;
    private $slug;
    private $is_wysiwyg_editor;

    /**
     * @return mixed
     */
    public function getIsWysiwygEditor()
    {
        return $this->is_wysiwyg_editor;
    }

    /**
     * @param mixed $is_wysiwyg_editor
     */
    public function setIsWysiwygEditor($is_wysiwyg_editor)
    {
        $this->is_wysiwyg_editor = $is_wysiwyg_editor;
    }

    /** @return mixed */
    public function getSlug()
    {
        return $this->slug;
    }

    /** @param mixed $slug */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function __construct() { }

    /** @return mixed */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /** @param mixed $is_active */
    public function setIsActive($is_active)
    {
        $this->is_active = $is_active;
    }

    /** @return binary */
    public function getPageUuid()
    {
        return $this->page_uuid;
    }

    /** @param binary $page_uuid */
    public function setPageUuid($page_uuid) { $this->page_uuid = $page_uuid; }

    /** @return mixed */
    public function getPageId()
    {
        return $this->page_id;
    }

    /** @param mixed $page_id */
    public function setPageId($page_id)
    {
        $this->page_id = $page_id;
    }

    /** @return mixed */
    public function getTitle()
    {
        return $this->title;
    }

    /** @param mixed $title */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /** @return mixed */
    public function getBody()
    {
        return $this->body;
    }

    /** @param mixed $body */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @param null|int $limit break string to smaller one
     * @return string
     */
    public function getDescription($limit = null)
    {
        if(!$limit) {
            return $this->description;
        }

        return mb_substr($this->description, 0, $limit);
    }

    /** @param mixed $description */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /** @return mixed */
    public function getMainImg()
    {
        return $this->main_img;
    }

    /** @param mixed $main_img */
    public function setMainImg($main_img)
    {
        $this->main_img = $main_img;
    }

    /** @return mixed */
    public function getHasLayout()
    {
        return $this->has_layout;
    }

    /**@param mixed $has_layout */
    public function setHasLayout($has_layout)
    {
        $this->has_layout = $has_layout;
    }

    /** @return mixed */
    public function getIsHomepage()
    {
        return $this->is_homepage;
    }

    /** @param mixed $is_homepage */
    public function setIsHomepage($is_homepage)
    {
        $this->is_homepage = $is_homepage;
    }

    /**
     * @param null|string $format Format date eg. "H:i d.m.Y"
     * @return false|string
     */
    public function getCreatedAt($format = null)
    {
        if(!$format) {
            return $this->created_at;
        }

        return date($format, strtotime($this->created_at));
    }

    /** @param string $created_at */
    public function setCreatedAt(string $created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * Hydrating result set from database
     *
     * @param array $data
     */
    public function exchangeArray($data = [])
    {
        foreach(array_keys(get_object_vars($this)) as $property) {
            $this->{$property} = isset($data[$property]) ? $data[$property] : null;
        }
    }

    /** @return Array */
    public function getArrayCopy()
    {
        return [
            'page_uuid'         => (binary)$this->page_uuid,
            'page_id'           => (string)$this->page_id,
            'title'             => (string)$this->title,
            'body'              => (string)$this->body,
            'description'       => (string)$this->description,
            'main_img'          => (string)$this->main_img,
            'has_layout'        => (boolean)$this->has_layout,
            'is_homepage'       => (boolean)$this->is_homepage,
            'is_active'         => (boolean)$this->is_active,
            'is_wysiwyg_editor' => (boolean)$this->is_wysiwyg_editor,
            'created_at'        => (string)$this->created_at,
            'slug'              => (string)$this->slug
        ];
    }

}