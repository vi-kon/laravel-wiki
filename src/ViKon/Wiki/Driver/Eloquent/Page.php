<?php
/**
 * Created by PhpStorm.
 * User: van Gogh
 * Date: 2016. 01. 23.
 * Time: 19:26
 */

namespace ViKon\Wiki\Driver\Eloquent;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use ViKon\Auth\Contracts\Keeper;
use ViKon\Wiki\Contract\Page as PageContract;
use ViKon\Wiki\Model\Page as PageModel;
use ViKon\Wiki\Model\PageContent;

/**
 * Class Page
 *
 * @package ViKon\Wiki\Driver\Eloquent
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
class Page implements PageContract
{
    /** @type \ViKon\Wiki\Model\Page */
    protected $model;

    /** @type \ViKon\Wiki\Driver\Eloquent\Repository */
    protected $repository;

    /** @type \ViKon\Auth\Contracts\Keeper */
    protected $keeper;

    /**
     * Page constructor.
     *
     * @param \ViKon\Wiki\Model\Page                 $page
     * @param \ViKon\Wiki\Driver\Eloquent\Repository $repository
     * @param \ViKon\Auth\Contracts\Keeper           $keeper
     */
    public function __construct(PageModel $page, Repository $repository, Keeper $keeper)
    {
        $this->model      = $page;
        $this->repository = $repository;
        $this->keeper     = $keeper;
    }

    /**
     * {@inheritDoc}
     */
    public function getUrl()
    {
        return $this->model->url;
    }

    /**
     * {@inheritDoc}
     */
    public function setUrl($url)
    {
        $this->model->url = $url;
    }

    /**
     * {@inheritDoc}
     */
    public function getToken()
    {
        return $this->model->id;
    }

    /**
     * {@inheritDoc}
     */
    public function getTitle()
    {
        return $this->model->title;
    }

    /**
     * {@inheritDoc}
     */
    public function getContent()
    {
        return $this->model->content;
    }

    /**
     * {@inheritDoc}
     */
    public function isDraft()
    {
        return $this->model->draft;
    }

    /**
     * {@inheritDoc}
     */
    public function isPublished()
    {
        return !$this->isDraft();
    }

    /**
     * {@inheritDoc}
     */
    public function getContents()
    {
        // Wrap page content models into page contents
        return $this->model->contents->map(function (PageContent $pageContent) {
            return $this->repository->contentByModel($pageContent);
        });
    }

    /**
     * {@inheritDoc}
     */
    public function getLastContent()
    {
        // Do not return page content if page is marked as draft (even on existing published page content)
        if ($this->isDraft()) {
            return null;
        }

        // Load page content from database
        /** @type \ViKon\Wiki\Model\PageContent|null $pageContent */
        $pageContent = $this->model->contents()
                                   ->where(PageContent::FIELD_DRAFT, false)
                                   ->orderBy(PageContent::FIELD_CREATED_AT, 'desc')
                                   ->first();

        // Wrap page content model into page content
        return $this->repository->contentByModel($pageContent);
    }

    /**
     * {@inheritDoc}
     */
    public function hasDraftForUser(Authenticatable $user)
    {
        return $this->model->contents()
                           ->where(PageContent::FIELD_DRAFT, true)
                           ->where(PageContent::FIELD_CREATED_BY_USER_ID, $user->getAuthIdentifier())
                           ->orderBy(PageContent::FIELD_CREATED_AT, 'desc')
                           ->exists();
    }

    /**
     * {@inheritDoc}
     */
    public function getDraftForUser(Authenticatable $user)
    {
        // Load page content from database
        /** @type \ViKon\Wiki\Model\PageContent|null $pageContent */
        $pageContent = $this->model->contents()
                                   ->where(PageContent::FIELD_DRAFT, true)
                                   ->where(PageContent::FIELD_CREATED_BY_USER_ID, $user->getAuthIdentifier())
                                   ->orderBy(PageContent::FIELD_CREATED_AT, 'desc')
                                   ->first();

        // Create new page content for given user if not found in database
        if ($pageContent === null) {

            $pageContent                     = new PageContent();
            $pageContent->draft              = true;
            $pageContent->created_by_user_id = $user->getAuthIdentifier();
            $pageContent->created_at         = new Carbon();

            // Set title and raw content for current draft if page was already published
            $lastContent = $this->getLastContent();
            if ($lastContent !== null) {
                $pageContent->title   = $lastContent->getTitle();
                $pageContent->content = $lastContent->getRawContent();
            }

            $this->model->contents()->save($pageContent);
        }

        // Wrap page content model into page content
        return $this->repository->contentByModel($pageContent);
    }

    /**
     * {@inheritDoc}
     */
    public function hasDraftForCurrentUser()
    {
        return $this->hasDraftForUser($this->keeper->user());
    }

    /**
     * {@inheritDoc}
     */
    public function getDraftForCurrentUser()
    {
        return $this->getDraftForUser($this->keeper->user());
    }

    /**
     * {@inheritDoc}
     */
    public function getToc()
    {
        return $this->model->toc;
    }

    /**
     * {@inheritDoc}
     */
    public function getHistory()
    {
        // Load contents from database which are not draft
        /** @type \Illuminate\Database\Eloquent\Collection $contents */
        $contents = $this->model->contents()
                                ->where('draft', false)
                                ->orderBy('created_at', 'desc')
                                ->get();

        // Wrap page content models into page contents
        return $contents->map(function (PageContent $pageContent) {
            return $this->repository->contentByModel($pageContent);
        });
    }

    /**
     * {@inheritDoc}
     */
    public function getListOfPagesWithReferences()
    {
        // TODO implement list of pages with references
    }

    /**
     * {@inheritDoc}
     */
    public function getListOfReferredPages()
    {
        // TODO implement list of pages with references
    }

    /**
     * {@inheritDoc}
     */
    public function save()
    {
        $this->model->save();
    }

    /**
     * {@inheritDoc}
     */
    public function delete()
    {
        // Do not delete model, just set to draft and empty title and content
        $this->model->title   = '';
        $this->model->content = '';
        $this->model->draft   = false;

        $this->model->save();
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        return $this->model->toArray();
    }

    /**
     * {@inheritDoc}
     */
    public function toJson($options = 0)
    {
        return $this->model->toJson($options);
    }

    /**
     * Get eloquent model which represents current page
     *
     * @return \ViKon\Wiki\Model\Page
     */
    public function getModel()
    {
        return $this->model;
    }
}