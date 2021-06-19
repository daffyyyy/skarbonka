<?php

namespace App\Models;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $table = 'announcements_category';

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }
}
