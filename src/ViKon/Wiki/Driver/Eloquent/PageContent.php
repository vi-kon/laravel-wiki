<?php

namespace ViKon\Wiki\Driver\Eloquent;

use Carbon\Carbon;
use ViKon\Wiki\Contract\PageContent as PageContentContract;
use ViKon\Wiki\Model\PageContent as PageContentModel;
use ViKon\Wiki\Parser\WikiParser;

/**
 * Class PageContent
 *
 * @package ViKon\Wiki\Driver\Eloquent
 *
 * @author  Kovács Vince <vincekovacs@hotmail.com>
 */
class PageContent implements PageContentContract
{
    /** @type \ViKon\Wiki\Model\PageContent */
    protected $model;

    /** @type \ViKon\Wiki\Driver\Eloquent\Repository */
    protected $repository;

    /** @type \ViKon\Wiki\Parser\WikiParser */
    protected $parser;

    /**
     * PageContent constructor.
     *
     * @param \ViKon\Wiki\Model\PageContent          $pageContent
     * @param \ViKon\Wiki\Driver\Eloquent\Repository $repository
     * @param \ViKon\Wiki\Parser\WikiParser          $parser
     */
    public function __construct(PageContentModel $pageContent, Repository $repository, WikiParser $parser)
    {
        $this->model      = $pageContent;
        $this->repository = $repository;
        $this->parser     = $parser;
    }

    /**
     * {@inheritDoc}
     */
    public function getPage()
    {
        return $this->repository->pageByModel($this->model->page);
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
    public function setTitle($title)
    {
        $this->model->title = trim($title);
    }

    /**
     * {@inheritDoc}
     */
    public function getContent()
    {
        return $this->parser->parse($this->getRawContent())->getContent();
    }

    /**
     * {@inheritDoc}
     */
    public function getRawContent()
    {
        return $this->model->content;
    }

    /**
     * {@inheritDoc}
     */
    public function setRawContent($content)
    {
        $this->model->content = $content;
    }

    /**
     * {@inheritDoc}
     */
    public function getViews()
    {
        return $this->model->views;
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
    public function publish()
    {
        $this->model->draft = false;
        $this->save();

        $page      = $this->getPage();
        $pageModel = $page->getModel();

        $data = $this->parser->parse($this->getRawContent(), $this->getTitle());

        $pageModel->draft   = false;
        $pageModel->title   = $data->getTitle();
        $pageModel->content = $data->getContent();
        $pageModel->toc     = $data->getToc();
        $page->save();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getCreatedByUser()
    {
        return $this->model->createdByUser;
    }

    /**
     * {@inheritDoc}
     */
    public function getCreatedAt()
    {
        return $this->model->created_at;
    }

    /**
     * {@inheritDoc}
     */
    public function save()
    {
        $this->model->created_at = new Carbon();

        $this->model->save();
    }

    /**
     * {@inheritDoc}
     */
    public function delete()
    {
        $this->model->delete();
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
     * Get eloquent model which represents current page content
     *
     * @return \ViKon\Wiki\Model\PageContent
     */
    public function getModel()
    {
        return $this->model;
    }
}