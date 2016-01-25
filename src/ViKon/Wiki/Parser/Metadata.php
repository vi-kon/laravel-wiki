<?php

namespace ViKon\Wiki\Parser;

/**
 * Class Metadata
 *
 * @package ViKon\Wiki\Parser
 *
 * @author  Kovács Vince <vincekovacs@hotmail.com>
 */
class Metadata
{
    /** @type string */
    protected $title;

    /** @type string */
    protected $content;

    /** @type array */
    protected $toc;

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get table of content
     *
     * @return array
     */
    public function getToc()
    {
        return $this->toc;
    }

    /**
     * Set table of content
     *
     * @param array $toc
     *
     * @return $this
     */
    public function setToc(array $toc)
    {
        $this->toc = $toc;

        return $this;
    }

}