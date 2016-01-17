<?php

namespace ViKon\Wiki\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ViKon\Auth\Model\User;
use ViKon\Wiki\Model\Page;

/**
 * \ViKon\Wiki\Models\PageContent
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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->created_at = new Carbon();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by_user_id', 'id');
    }
}