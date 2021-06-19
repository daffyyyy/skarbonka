<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class AnnouncementObserver
{
    /**
     * Handle the Announcement "creating" event.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return void
     */
    public function creating(Announcement $announcement)
    {
        $announcement->user_id = auth()->id();
        $announcement->slug = Str::slug($announcement->title . ' ' . rand(1111, 999999999), '-');
    }

    /**
     * Handle the Announcement "updated" event.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return void
     */
    public function updated(Announcement $announcement)
    {
        //
    }

    /**
     * Handle the Announcement "deleted" event.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return void
     */
    public function deleted(Announcement $announcement)
    {
        //
    }

    /**
     * Handle the Announcement "restored" event.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return void
     */
    public function restored(Announcement $announcement)
    {
        //
    }

    /**
     * Handle the Announcement "force deleted" event.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return void
     */
    public function forceDeleted(Announcement $announcement)
    {
        //
    }
}
