<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;
    protected $fillable = ['title','author', 'published_at','is_active', 'category_id','created_by,borrwo_to'];

    protected $casts = ['is_active' => 'boolean'];

    public function category(): BelongsTo{
       return $this->belongsTo(Category::class);
    }

    public function user(){
        return $this->belongsTo(User::class,'created_by');
    }
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }
    protected $appends = ['category_name'];

    public function getCategoryNameAttribute()
    {
        return $this->category?->name;
    }
}
