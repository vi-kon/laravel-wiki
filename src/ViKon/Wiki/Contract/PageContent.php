<?php

namespace ViKon\Wiki\Contract;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

/**
 * Interface PageContent
 *
 * @package ViKon\Wiki\Contract
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
interface PageContent extends Arrayable, Jsonable
{
    /**
     * Get associated page
     *
     * @return \ViKon\Wiki\Contract\Page
     */
    public function getPage();

    /**
     * Get page title for current content
     *
     * @return string
     */
    public function getTitle();

    /**
     * Set page title for current content
     *
     * @param string $title
     *
     * @return static
     */
    public function setTitle($title);

    /**
     * Get page's rendered content
     *
     * Note: This will return rendered HTML content
     *
     * @return string
     */
    public function getContent();

    /**
     * Get page's raw content
     *
     * Note: This will return original content written in Markdown
     *
     * @return string
     */
    public function getRawContent();

    /**
     * Set page's raw content
     *
     * @param string $content
     *
     * @return static
     */
    public function setRawContent($content);

    /**
     * Get how many people viewed this content
     *
     * @return int
     */
    public function getViews();

    /**
     * Check if current content is draft or not
     *
     * @return bool
     */
    public function isDraft();

    /**
     * Check if current content is published or not
     *
     * @return bool
     */
    public function isPublished();

    /**
     * Publish current content
     *
     * @return static
     */
    public function publish();

    /**
     * Get content creator
     *
     * @return \ViKon\Auth\Model\User
     */
    public function getCreatedByUser();

    /**
     * Get date when content was published
     *
     * Note: If content is not published (is draft) then this date represent last edit date
     *
     * @return \Carbon\Carbon
     */
    public function getCreatedAt();

    /**
     * Save changes made on current content
     *
     * @return static
     */
    public function save();

    /**
     * Delete only page's current content
     *
     * @return static
     */
    public function delete();
}