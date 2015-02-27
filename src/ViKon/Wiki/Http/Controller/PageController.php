<?php

namespace ViKon\Wiki\Http\Controller;

use Illuminate\Http\Request;
use ViKon\Wiki\Models\Page;
use ViKon\Wiki\Models\PageContent;
use ViKon\Wiki\WikiParser;

class PageController extends BaseController {

    /**
     * @param string $url
     *
     * @return \Illuminate\View\View
     */
    public function show($url = '') {
        /** @var Page $page */
        $page = Page::where('url', $url)->first();

        $authUser = app('auth.role.user');

        if ($page !== null && !$page->draft) {
            $titleId = WikiParser::generateId($page->title);

            $editable = $authUser->hasRole('wiki.edit');
            $movable = $authUser->hasRole('wiki.move');
            $destroyable = $authUser->hasRole('wiki.destroy');

            return view(config('wiki.views.page.show'))
                ->with('editable', $editable)
                ->with('movable', $movable)
                ->with('destroyable', $destroyable)
                ->with('titleId', $titleId)
                ->with('page', $page);
        }

        $creatable = $authUser->hasRole('wiki.create');

        return view(config('wiki.views.page.not-exists'))
            ->with('url', $url)
            ->with('creatable', $creatable);
    }

    public function edit($url = '') {
        /** @var Page $page */
        $page = Page::where('url', $url)->first();

        if ($page === null || $page->draft) {
            return redirect()->route('wiki.create', ['url' => $url]);
        }

        $draftExists = true;
        $lastContent = $page->lastContent();
        \DB::connection()->transaction(function () use ($url, $page, $lastContent, &$draftExists) {

            if (($pageContent = $page->userDraft()) === null) {
                $pageContent = new PageContent();
                $pageContent->title = $lastContent->title;
                $pageContent->content = $lastContent->content;
                $pageContent->draft = true;
                $pageContent->created_by_user_id = app('auth.role.user')->getUserId();
                $page->contents()->save($pageContent);

                $draftExists = false;
            }
        });

        $userDraft = $page->userDraft();

        return view(config('wiki.views.page.edit'))
            ->with('page', $page)
            ->with('draftExists', $draftExists)
            ->with('userDraft', $userDraft)
            ->with('lastContent', $lastContent);
    }

    public function ajaxModalPreview(Page $page, Request $request) {
        $content = WikiParser::parseContent($request->get('content', ''));

        return \View::make('wiki::page/create-modal-preview')
            ->with('content', $content)
            ->with('url', $page->url);

    }
}