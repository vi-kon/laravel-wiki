<?php

namespace ViKon\Wiki\Contract;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
/**
 * Interface Page
 *
 * @package ViKon\Wiki\Contract
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
interface Page extends Arrayable, Jsonable
{
    /**
     * Get page URL
     *
     * @return string
     */
    public function getUrl();

    /**
     * Set page URL
     *
     * @param string $url
     *
     * @return static
     */
    public function setUrl($url);

    /**
     * Get unique token for page
     *
     * @return string
     */
    public function getToken();

    /**
     * Get page's title
     *
     * Note: This will return last published content's title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Get page's rendered content
     *
     * Note: This will return last published content's rendered content
     *
     * @return string
     */
    public function getContent();

    /**
     * Check if page has only unpublished contents or not
     *
     * Note: Return TRUE if page has only unpublished (draft) contents, otherwise FALSE
     *
     * @return bool
     */
    public function isDraft();

    /**
     * Check if page has least one published content or not
     *
     * Note: Return TRUE if page has least one published (not draft) contents, otherwise FALSE
     *
     * @return bool
     */
    public function isPublished();

    /**
     * Get list of content
     *
     * @return \ViKon\Wiki\Contract\PageContent[]|\Illuminate\Support\Collection
     */
    public function getContents();

    /**
     * Get last content's instance
     *
     * Note: This method can return draft contents too
     *
     * @return \ViKon\Wiki\Contract\PageContent
     */
    public function getLastContent();

    /**
     * Get draft content for current user
     *
     * Note: If user has no existing draft to current page then new draft will be created base on last published content
     *
     * @return \ViKon\Wiki\Contract\PageContent
     */
    public function getDraftForCurrentUser();

    /**
     * Get page's table of content
     *
     * @return string[]
     */
    public function getToc();

    /**
     * Get all published contents ordered by publish date
     *
     * @return \ViKon\Wiki\Contract\PageContent[]|\Illuminate\Support\Collection
     */
    public function getHistory();

    /**
     * Get pages which has any reference to this page
     *
     * Note: List contains only pages which contents have internal link referred to this page
     *
     * @return \ViKon\Wiki\Contract\Page
     */
    public function getListOfPagesWithReferences();

    /**
     * Get pages which are referred from this page
     *
     * @return \ViKon\Wiki\Contract\Page
     */
    public function getListOfReferredPages();

    /**
     * Save changes made on page
     *
     * @return static
     */
    public function save();

    /**
     * Delete whole page
     *
     * @return static
     */
    public function delete();
}