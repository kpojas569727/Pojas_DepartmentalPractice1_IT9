<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    // Single source of truth for allowed values (used by validation and dropdowns)
    public const CATEGORIES = ['ornamental', 'flowering', 'succulent', 'herb'];
    public const STATUSES = ['in_stock' => 'In Stock', 'out_of_stock' => 'Out of Stock'];

    protected $fillable = ['user_id', 'name', 'category', 'unit_price', 'description', 'stock_status'];

    /**
     * Relationship: A Plant belongs to a User (the creator).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Readable label, e.g. "out_of_stock" becomes "Out of Stock"
    public function getStockLabelAttribute()
    {
        return self::STATUSES[$this->stock_status] ?? $this->stock_status;
    }
}
