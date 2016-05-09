<?php

namespace ViKon\Wiki\Http\Controller;

use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use ViKon\Diff\Diff;
use ViKon\Wiki\Contract\Page;
use ViKon\Wiki\Http\Requests\PageMoveRequest;
use ViKon\Wiki\WikiEngine;
use ViKon\Wiki\WikiParserOld;

/**
 * Class PageController
 *
 * @package ViKon\Wiki\Http\Controller
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
class PageController extends BaseController
{
    /**
     * Show page
     *
     * @param string $url
     *
     * @return \Illuminate\View\View
     */
    public function show($url = '')
    {
        $session    = $this->container->make(SessionManager::class)->driver();
        $repository = $this->container->make(WikiEngine::class)->repository();

        $page = $repository->page($url);

        if ($page->isPublished()) {

            $titleId = WikiParserOld::generateId($page->getTitle());

            return view(config('wiki.views.page.show'))
                ->with('titleId', $titleId)
                ->with('message', $session->get('message', null))
                ->with('page', $page);
        }


        return view(config('wiki.views.page.not-exists'))
            ->with('page', $page);
    }

    /**
     * @param string $url
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create($url = '')
    {
        $repository = $this->container->make(WikiEngine::class)->repository();

        $page = $repository->page($url);

        if ($page->isPublished()) {
            return redirect()->route('wiki.page.edit', ['url' => $url]);
        }

        $userDraft = $page->getDraftForCurrentUser();

        return view(config('wiki.views.page.create'))
            ->with('page', $page)
            ->with('userDraft', $userDraft);

    }

    /**
     * Show page edit
     *
     * @param string $url
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Exception
     */
    public function edit($url = '')
    {
        $repository = $this->container->make(WikiEngine::class)->repository();

        $page = $repository->page($url);

        if ($page->isDraft()) {
            return redirect()->route('wiki.create', ['url' => $url]);
        }

        $userDraft = $page->getDraftForCurrentUser();

        return view(config('wiki.views.page.edit'))
            ->with('page', $page)
            ->with('userDraft', $userDraft);
    }

    /**
     * Handle draft save request
     *
     * @param \ViKon\Wiki\Contract\Page $page
     * @param \Illuminate\Http\Request  $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ajaxStoreDraft(Page $page, Request $request)
    {
        $draftPageContent = $page->getDraftForCurrentUser();

        $draftPageContent->setTitle($request->get('title', ''));
        $draftPageContent->setRawContent($request->get('content', ''));
        $draftPageContent->save();

        return response()->json();
    }

    /**
     * Handle page store request
     *
     * @param \ViKon\Wiki\Contract\Page $page
     * @param \Illuminate\Http\Request  $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ajaxStore(Page $page = null, Request $request)
    {
        $session = $this->container->make(SessionManager::class)->driver();

//        list($content, $toc, $urls) = WikiParserOld::parsePage($request->get('title', ''), $request->get('content', ''));

//        $absoluteUrl = preg_quote(route('wiki.show') . '/', '/');
//        $relativeUrl = preg_quote(str_replace(url('/'), '', route('wiki.show')) . '/', '/');

//        foreach ($urls as $url) {
//            if (preg_match('/^(?:' . $absoluteUrl . '|' . $relativeUrl . ')/', $url)) {
//                // TODO
//            }
//        }

//        $page->setToc($toc);

        $userDraft = $page->getDraftForCurrentUser();
        $userDraft->setTitle($request->get('title', ''));
        $userDraft->setRawContent($request->get('content', ''));

        $userDraft->publish();

        $session->flash('message', trans('wiki::page/create.alert.saved.content'));

        return response()->json();
    }

    /**
     * Show preview modal dialog
     *
     * @param \ViKon\Wiki\Contract\Page $page
     * @param \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\View\View
     */
    public function ajaxModalPreview(Page $page, Request $request)
    {
        $content = WikiParserOld::parseContent($request->get('content', ''));

        return view(config('wiki.views.page.modal.preview'))
            ->with('content', $content)
            ->with('url', $page->getUrl());
    }

    /**
     * Show cancel modal dialog
     *
     * @param \ViKon\Wiki\Contract\Page $page
     *
     * @return \Illuminate\View\View
     */
    public function ajaxModalCancel(Page $page)
    {
        return view(config('wiki.views.page.modal.cancel'))
            ->with('page', $page);
    }

    /**
     * Handle cancel request
     *
     * @param \ViKon\Wiki\Contract\Page $page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function ajaxCancel(Page $page)
    {
        $page->getDraftForCurrentUser()->delete();

        $this->container->make(SessionManager::class)->driver()
                        ->flash('message', trans('wiki::page/create.alert.cancelled.content'));

        return response()->json();
    }

    /**
     * Show history modal dialog
     *
     * @param \ViKon\Wiki\Contract\Page $page
     *
     * @return \Illuminate\View\View
     */
    public function ajaxModalHistory(Page $page)
    {
        $contents = $page->getHistory();

        $oldContent = '';
        for ($i = $contents->count() - 1; $i >= 0; $i--) {
            $contents[$i] = [
                'content' => $contents[$i],
                'diff'    => Diff::compare($oldContent, $contents[$i]->content),
            ];

            $oldContent = $contents[$i]['content']->content;
        }

        return view(config('wiki.views.page.modal.history'))
            ->with('page', $page)
            ->with('contents', $contents);
    }

    /**
     * Show move modal dialog
     *
     * @param \ViKon\Wiki\Contract\Page $page
     *
     * @return \Illuminate\View\View
     */
    public function ajaxModalMove(Page $page)
    {
        return view(config('wiki.views.page.modal.move'))
            ->with('page', $page);
    }

    /**
     * Handle move request
     *
     * @param \ViKon\Wiki\Contract\Page                 $page
     * @param \ViKon\Wiki\Http\Requests\PageMoveRequest $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ajaxMove(Page $page, PageMoveRequest $request)
    {
        $source = $page->getUrl();

        $page->setUrl($request->get('destination'));
        $page->save();

        return view(config('wiki.views.page.modal.move-success'))
            ->with('source', $source)
            ->with('page', $page);
    }

    /**
     * @param \ViKon\Wiki\Contract\Page $page
     *
     * @return \Illuminate\View\View
     */
    public function ajaxModalDestroy(Page $page)
    {
        return view(config('wiki.views.page.modal.destroy'))
            ->with('page', $page);
    }

    /**
     * @param \ViKon\Wiki\Contract\Page $page
     *
     * @return \Illuminate\View\View
     *
     * @throws \Exception
     */
    public function ajaxDestroy(Page $page)
    {
        $title = $page->getTitle();
        $url   = $page->getUrl();
        $page->delete();

        return view(config('wiki.views.page.modal.destroy-success'))
            ->with('title', $title)
            ->with('url', $url);
    }
}