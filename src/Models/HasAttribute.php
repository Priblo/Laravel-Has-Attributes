<?php

namespace Priblo\LaravelHasAttributes\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HasAttribute
 * @package App\Models
 */
class HasAttribute extends Model
{
    protected $table = 'has_attributes';
    protected $primaryKey = 'has_attribute_id';

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
            'foreign_type' => get_class($Model)
        ]);
    }
}
