<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'amount',
        'cost',
        'contact',
        'category_id',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // public function getContactAttribute($value)
    // {
    //     return nl2br(e(strip_tags($value)), false);
    // }

    public function category()
    {
        return DB::table('announcements_category')->where('id', $this->category_id)->first();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
