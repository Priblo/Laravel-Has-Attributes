<?php

namespace Priblo\LaravelHasSettings\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HasSetting
 * @package App\Models
 */
class HasSetting extends Model
{
    protected $table = 'has_settings';
    protected $primaryKey = 'has_setting_id';

    /**
     * Scope a query to limit results only to the referenced model
     *
     * @param Builder $query
     * @param Model $Model
     * @return Builder
     */
    public function scopeOfForeign($query, Model $Model)
    {
        return $query->where([
            'foreign_id' => $Model->getKey(),
            'foreign_model' => get_class($Model)
        ]);
    }
}
