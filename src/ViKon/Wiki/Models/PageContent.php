<?php

namespace ViKon\Wiki\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * \ViKon\Wiki\Models\PageContent
 *
 * @property integer                      $id
 * @property string                       $title
 * @property string                       $content
 * @property integer                      $views
 * @property boolean                      $draft
 * @property integer                      $page_id
 * @property integer                      $created_by_user_id
 * @property \Carbon\Carbon               $created_at
 * @property-read \ViKon\Wiki\Models\Page $page
 * @property-read \ViKon\Auth\Models\User $createdByUser
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Models\PageContent whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Models\PageContent whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Models\PageContent whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Models\PageContent whereViews($value)
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Models\PageContent whereDraft($value)
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Models\PageContent wherePageId($value)
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Models\PageContent whereCreatedByUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Models\PageContent whereCreatedAt($value)
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
        return $this->belongsTo('\ViKon\Wiki\Models\Page', 'page_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdByUser()
    {
        return $this->belongsTo('ViKon\Auth\models\User', 'created_by_user_id', 'id');
    }
}