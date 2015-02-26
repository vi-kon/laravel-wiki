<?php

namespace ViKon\Wiki\Http\Controller;

use ViKon\Wiki\Models\Page;
use ViKon\Wiki\WikiParser;

class PageController extends BaseController {

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
}