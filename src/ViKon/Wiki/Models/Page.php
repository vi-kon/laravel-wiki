<?php

namespace ViKon\Wiki\Models;

/**
 * \ViKon\Wiki\Models\Page
 *
 * @property integer                                                           $id
 * @property string                                                            $url
 * @property string                                                            $type
 * @property string                                                            $title
 * @property string                                                            $toc
 * @property string                                                            $content
 * @property boolean                                                           $draft
 * @property-read \Illuminate\Database\Eloquent\Collection|\ViKon\Wiki\Models\PageContent[] $contents
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Models\Page whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Models\Page whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Models\Page whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Models\Page whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Models\Page whereToc($value)
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Models\Page whereDraft($value)
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Models\Page whereContent($value)
 */
class Page extends \Eloquent {

    const TYPE_MARKDOWN = 'markdown';

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
    protected $table = 'wiki_pages';

    protected $fillable = ['url', 'type'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contents() {
        return $this->hasMany('\ViKon\Wiki\Models\PageContent', 'page_id', 'id');
    }

    /**
     * @return \ViKon\Wiki\Models\PageContent|null
     */
    public function userDraft() {
        return $this->contents()
            ->where('draft', true)
            ->where('created_by_user_id', \Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    /**
     * @return \ViKon\Wiki\Models\PageContent|null
     */
    public function lastContent() {
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
    public function getTocAttribute($toc) {
        return unserialize($toc);
    }

    /**
     * @param mixed $toc
     */
    public function setTocAttribute($toc) {
        $this->attributes['toc'] = serialize($toc);
    }
}