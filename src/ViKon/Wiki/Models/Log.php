<?php

namespace ViKon\Wiki\Models;

/**
 * \ViKon\Wiki\Models\Log
 *
 * @property integer                      $id
 * @property string                       $name
 * @property string                       $data
 * @property \Carbon\Carbon               $created_at
 * @property integer                      $created_by_user_id
 * @property-read \ViKon\Auth\Models\User $createdByUser
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Models\Log whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Models\Log whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Models\Log whereData($value)
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Models\Log whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\ViKon\Wiki\Models\Log whereCreatedByUserId($value)
 */
class Log extends \Eloquent {

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
    protected $table = 'wiki_logs';

    /**
     * @param $data
     *
     * @return mixed[]
     */
    public function getDataAttribute($data) {
        return unserialize($data);
    }

    /**
     * @param mixed $data
     */
    public function setDataAttribute($data) {
        $this->attributes['data'] = serialize($data);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdByUser() {
        return $this->belongsTo('ViKon\Auth\models\User', 'id', 'created_by_user_id');
    }
}