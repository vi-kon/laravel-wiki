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
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Model\PageContent whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Model\PageContent whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Model\PageContent whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Model\PageContent whereViews($value)
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Model\PageContent whereDraft($value)
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Model\PageContent wherePageId($value)
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Model\PageContent whereCreatedByUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Model\PageContent whereCreatedAt($value)
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
     *
     * Disable updated_at and created_at columns
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'wiki_pages_content';

    /**
     * PageContent constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->dates = [
            'created_at',
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