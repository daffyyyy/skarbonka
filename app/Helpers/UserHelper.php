<?php

use App\Models\User;

function GetUserName(User $user, bool $badges = true): string
{
    $name = '<a href="' . route('uzytkownik.show', $user) . '">' . $user->name . '</a>';
    if ($badges) 
    {
        if ($user->is_admin) {
            $name .= ' <span class="badge bg-danger"><i class="fas fa-shield-alt"></i> ADMIN</span>';
        }
        if ($user->is_vip) {
            $name .= ' <span class="badge bg-warning"><i class="far fa-gem"></i> VIP</span>';
        }
        if ($user->reputation >= 10) {
            $name .= ' <span class="badge bg-success"><i class="far fa-thumbs-up"></i> Dobra reputacja</span>';
        }
    }
    return $name;
}
