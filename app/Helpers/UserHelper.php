<?php

use App\Models\User;

function getUserName(User $user, bool $badges = true): string
{
    $name = '<a href="' . route('uzytkownik.show', $user) . '">' . $user->name . '</a>';
    if ($badges) {
        if ($user->is_admin) {
            $name .= ' <span class="badge bg-danger"><i class="fas fa-shield-alt"></i> ADMIN</span>';
        }
        if ($user->is_vip) {
            $name .= ' <span class="badge bg-warning"><i class="far fa-gem"></i> VIP</span>';
        }
        if ($user->is_bot) {
            $name .= ' <span class="badge bg-info"><i class="fas fa-robot"></i> BOT</span>';
        }
        if ($user->reputation >= 10) {
            $name .= ' <span class="badge bg-success"><i class="far fa-thumbs-up"></i> Dobra reputacja</span>';
        }
    }
    return $name;
}

function getUserAvatar(User $user, $profileLink = true, $lightbox = false, $width = 125, $height = 125): string
{
    $avatar = $user->avatar;

    if (!$profileLink && $lightbox) {
        return '<a href="' . $avatar . '" data-lightbox="avatar"><img src="' . $avatar . '" class="rounded-circle border shadow-4" style="width: ' . $width . 'px; height: ' . $height . 'px;" /></a>';
    }

    return '<a href="' . route('uzytkownik.show', $user) . '"><img src="' . $avatar . '" class="rounded-circle border shadow-4" style="width: ' . $width . 'px; height: ' . $height . 'px;" /></a>';
}

function canAddAnnouncement(User $user): bool
{
    if ($user->is_vip && $user->announcements()->count() >= 10 || !$user->is_vip && $user->announcements()->count() >= 5) {
        return false;
    }
    return true;
}
