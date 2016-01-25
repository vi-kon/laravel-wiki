<?php

namespace ViKon\Wiki\Contract;

/**
 * Interface Repository
 *
 * @package ViKon\Wiki\Contract
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
interface Repository
{
    /**
     * Get page by URL
     *
     * Note: If page not exists than it will be created and marked as draft
     *
     * @param string $url
     *
     * @return \ViKon\Wiki\Contract\Page
     */
    public function page($url);

    /**
     * Get page by token
     *
     * @param string $token
     *
     * @return \ViKon\Wiki\Contract\Page|null return NULL if page not found by token
     */
    public function pageByToken($token);
}