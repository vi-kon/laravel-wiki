<?php

namespace ViKon\Wiki\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ViKon\Auth\Model\User;

/**
 * \ViKon\Wiki\Model\PageContent
 *
 * @property integer                     $id
 * @property string                      $title
 * @property string                      $content
 * @property integer                     $views
 * @property boolean                     $draft
 * @property integer                     $page_id
 * @property integer                     $created_by_user_id
 * @property \Carbon\Carbon              $created_at
 * @property-read Page                   $page
 * @property-read \ViKon\Auth\Model\User $createdByUser
 *
 * @author Kovács Vince<vincekovacs@hotmail.com>
 */
class PageContent extends Model
{
    use SoftDeletes;

    const FIELD_ID                 = 'id';
    const FIELD_TITLE              = 'title';
    const FIELD_CONTENT            = 'content';
    const FIELD_VIEWS              = 'views';
    const FIELD_DRAFT              = 'draft';
    const FIELD_PAGE_ID            = 'page_id';
    const FIELD_CREATED_BY_USER_ID = 'created_by_user_id';
    const FIELD_CREATED_AT         = 'created_at';

    /**
     * PageContent constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->table      = 'wiki_pages_content';
        $this->timestamps = false;
        $this->dates      = [
            static::CREATED_AT,
        ];
        ];

        parent::__construct($attributes);

        $this->created_at = new Carbon();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Eloquent\Builder
     */
    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Eloquent\Builder
     */
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by_user_id', 'id');
    }
}