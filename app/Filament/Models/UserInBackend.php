<?php

namespace App\Filament\Models;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Foundation\Auth\User as Authenticatable;


class UserInBackend extends Authenticatable implements FilamentUser
{
    public function canAccessFilament(): bool
    {
        return str_ends_with($this->email, '@admin.com');
        //  && $this->hasVerifiedEmail();
    }

}
