<?php

namespace ViKon\Wiki\Driver\Eloquent;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Collection;
use ViKon\Wiki\Contract\Repository as RepositoryContract;
use ViKon\Wiki\Model\Page as PageModel;
use ViKon\Wiki\Model\PageContent as PageContentModel;

/**
 * Class Repository
 *
 * @package ViKon\Wiki\Driver\Eloquent
 *
 * @author  Kovács Vince <vincekovacs@hotmail.com>
 */
class Repository implements RepositoryContract
{
    /** @type \Illuminate\Contracts\Container\Container */
    protected $container;

    /** @type \Illuminate\Support\Collection|\ViKon\Wiki\Driver\Eloquent\Page[] */
    protected $pages;

    /** @type \Illuminate\Support\Collection|\ViKon\Wiki\Driver\Eloquent\PageContent[] */
    protected $pageContents;

    /**
     * PageRepository constructor.
     *
     * @param \Illuminate\Contracts\Container\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container    = $container;
        $this->pages        = new Collection();
        $this->pageContents = new Collection();
    }

    /**
     * {@inheritDoc}
     */
    public function page($url)
    {
        // First try to load from cache
        /** @type \ViKon\Wiki\Driver\Eloquent\Page|null $page */
        $page = $this->pages->first(function ($key, Page $page) use ($url) {
            return $page->getUrl() === $url;
        });

        if ($page !== null) {
            return $page;
        }

        /** @type \ViKon\Wiki\Model\Page|null $pageModel */
        $pageModel = PageModel::query()
                              ->where(PageModel::FIELD_URL, $url)
                              ->first();

        if ($pageModel === null) {
            // If page not exists then new page will be created and stored in database
            $pageModel        = new PageModel();
            $pageModel->url   = $url;
            $pageModel->draft = true;
            $pageModel->save();
        }

        return $this->wrapPageModelToPage($pageModel);
    }

    /**
     * {@inheritDoc}
     */
    public function pageByToken($token)
    {
        $page = $this->pages->first(function ($key, Page $page) use ($token) {
            return $page->getToken() === $token;
        });

        if ($page !== null) {
            return $page;
        }

        /** @type \ViKon\Wiki\Model\Page|null $pageModel */
        $pageModel = PageModel::query()
                              ->where(PageModel::FIELD_ID, (int)$token)
                              ->first();

        if ($pageModel === null) {
            return null;
        }

        return $this->wrapPageModelToPage($pageModel);
    }

    /**
     * Get page by model
     *
     * @param \ViKon\Wiki\Model\Page $pageModel
     *
     * @return \ViKon\Wiki\Driver\Eloquent\Page
     */
    public function pageByModel(PageModel $pageModel)
    {
        // First try to load from cache
        /** @type \ViKon\Wiki\Driver\Eloquent\Page|null $page */
        $page = $this->pages->first(function ($key, Page $page) use ($pageModel) {
            return $page->getModel() === $pageModel;
        });

        if ($page !== null) {
            return $page;
        }

        return $this->wrapPageModelToPage($pageModel);
    }

    /**
     * Get page content by model
     *
     * @param \ViKon\Wiki\Model\PageContent $pageContentModel
     *
     * @return \ViKon\Wiki\Driver\Eloquent\PageContent
     */
    public function contentByModel(PageContentModel $pageContentModel)
    {
        // First try to load from cache
        /** @type \ViKon\Wiki\Driver\Eloquent\PageContent|null $pageContent */
        $pageContent = $this->pageContents->first(function ($key, PageContent $pageContent) use ($pageContentModel) {
            return $pageContent->getModel() === $pageContentModel;
        });

        if ($pageContent !== null) {
            return $pageContent;
        }

        return $this->wrapPageContentModelToPageContent($pageContentModel);
    }

    /**
     * Wrap eloquent Page model to engine's Page instance
     *
     * @param \ViKon\Wiki\Model\Page $pageModel
     *
     * @return \ViKon\Wiki\Driver\Eloquent\Page
     */
    protected function wrapPageModelToPage(PageModel $pageModel)
    {
        $this->pages[$pageModel->id] = new Page($pageModel, $this);

        return $this->pages[$pageModel->id];
    }

    /**
     * Wrap eloquent PageContent model to engine's PageContent instance
     *
     * @param \ViKon\Wiki\Model\PageContent $pageContentModel
     *
     * @return \ViKon\Wiki\Driver\Eloquent\PageContent
     */
    protected function wrapPageContentModelToPageContent(PageContentModel $pageContentModel)
    {
        $this->pageContents[$pageContentModel->id] = new PageContent($pageContentModel, $this);

        return $this->pageContents[$pageContentModel->id];
    }
}