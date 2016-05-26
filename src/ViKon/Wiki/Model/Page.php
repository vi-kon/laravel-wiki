<?php

namespace ViKon\Wiki\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ViKon\Auth\Contracts\Keeper;

/**
 * \ViKon\Wiki\Model\Page
 *
 * @property integer                                                                       $id
 * @property string                                                                        $url
 * @property string                                                                        $type
 * @property string                                                                        $title
 * @property string                                                                        $toc
 * @property string                                                                        $content
 * @property boolean                                                                       $draft
 * @property-read \Illuminate\Database\Eloquent\Collection|\ViKon\Wiki\Model\PageContent[] $contents
 *
 * @author Kovács Vince<vincekovacs@hotmail.com>
 */
class Page extends Model
{
    use SoftDeletes;

    const FIELD_ID      = 'id';
    const FIELD_URL     = 'url';
    const FIELD_TYPE    = 'type';
    const FIELD_TITLE   = 'title';
    const FIELD_TOC     = 'toc';
    const FIELD_CONTENT = 'content';
    const FIELD_DRAFT   = 'draft';

    const TYPE_MARKDOWN = 'markdown';

    public static function boot()
    {
        parent::boot();

        // Trigger delete all contents if page is deleted
        static::deleted(function (Page $page) {
            $page->contents()->delete();
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     * Page constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->table      = 'wiki_pages';
        $this->timestamps = false;
        $this->fillable   = [
            static::FIELD_URL,
            static::FIELD_TYPE,
        ];

        parent::__construct($attributes);
    }

    /**
     */
    public function contents()
    {
        return $this->hasMany(PageContent::class, 'page_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|\Illuminate\Database\Eloquent\Builder
     */
    public function refersTo()
    {
        return $this->belongsToMany(Page::class, 'wiki_pages_links', 'page_id', 'refers_to_page_id')
                    ->withPivot('url');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|\Illuminate\Database\Eloquent\Builder
     */
    public function refersFrom()
    {
        return $this->belongsToMany(Page::class, 'wiki_pages_links', 'refers_to_page_id', 'page_id');
    }

    /**
     * @return \ViKon\Wiki\Model\PageContent|null
     */
    public function userDraft()
    {
        return $this->contents()
                    ->where('draft', true)
                    ->where('created_by_user_id', app(Keeper::class)->id())
                    ->orderBy('created_at', 'desc')
                    ->first();
    }

    /**
     * @return \ViKon\Wiki\Model\PageContent|null
     */
    public function lastContent()
    {
        return $this->contents()
                    ->where('draft', false)
                    ->orderBy('created_at', 'desc')
                    ->first();
    }

    /**
     * @param $toc
     *
     * @return mixed[]
     */
    public function getTocAttribute($toc)
    {
        return unserialize($toc);
    }

    /**
     * @param mixed $toc
     */
    public function setTocAttribute($toc)
    {
        $this->attributes['toc'] = serialize($toc);
    }
}