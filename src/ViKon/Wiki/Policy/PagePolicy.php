<?php

namespace ViKon\Wiki\Policy;

use ViKon\Auth\Model\User;
use ViKon\Wiki\Contract\Page;

/**
 * Class PagePolicy
 *
 * @package ViKon\Wiki\Policy
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
class PagePolicy
{
    /**
     * Check if user can create page
     *
     * @param \ViKon\Auth\Model\User    $user
     * @param \ViKon\Wiki\Contract\Page $page
     *
     * @return bool
     */
    public function create(User $user, Page $page)
    {
        return $user->hasPermission('wiki.page.create');
    }

    /**
     * Check if user can edit page
     *
     * @param \ViKon\Auth\Model\User    $user
     * @param \ViKon\Wiki\Contract\Page $page
     *
     * @return bool
     */
    public function edit(User $user, Page $page)
    {
        return $user->hasPermission('wiki.page.edit');
    }

    /**
     * Check if user can move page
     *
     * @param \ViKon\Auth\Model\User    $user
     * @param \ViKon\Wiki\Contract\Page $page
     *
     * @return bool
     */
    public function move(User $user, Page $page)
    {
        return $user->hasPermission('wiki.page.move');
    }

    /**
     * Check if user can destroy page
     *
     * @param \ViKon\Auth\Model\User    $user
     * @param \ViKon\Wiki\Contract\Page $page
     *
     * @return bool
     */
    public function destroy(User $user, Page $page)
    {
        return $user->hasPermission('wiki.page.destroy');
    }
}