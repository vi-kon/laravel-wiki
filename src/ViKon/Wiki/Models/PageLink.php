<?php

namespace ViKon\Wiki\Models;

/**
 * \ViKon\Wiki\Models\PageLink
 *
 * @property integer                      $id
 * @property integer                      $source_page_id
 * @property integer                      $target_page_id
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Models\PageLink whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Models\PageLink whereSourcePageId($value)
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Models\PageLink whereTargetPageId($value)
 * @property-read \ViKon\Wiki\Models\Page $sourcePage
 * @property-read \ViKon\Wiki\Models\Page $targetPage
 */
class PageLink extends \Eloquent {

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
    protected $table = 'wiki_pages_links';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sourcePage() {
        return $this->belongsTo('\ViKon\Wiki\Models\Page', 'id', 'source_page_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function targetPage() {
        return $this->belongsTo('\ViKon\Wiki\Models\Page', 'id', 'target_page_id');
    }
}