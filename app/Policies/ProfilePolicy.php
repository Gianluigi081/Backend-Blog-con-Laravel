<?php

namespace App\Policies;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProfilePolicy
{
    use HandlesAuthorization;

    public function view(User $user, Profile $profile)
    {
        //Revisar si el usuario autenticado está viendo su perfil
        return $user->id === $profile->user_id;
    }
   
    public function update(User $user, Profile $profile)
    {
        //Revisar si el usuario autenticado está editando su perfil
        return $user->id === $profile->user_id;
    }

}
