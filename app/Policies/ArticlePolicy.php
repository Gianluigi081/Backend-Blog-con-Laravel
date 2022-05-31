<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    public function view(User $user, Article $article)
    {
        //Revisar si el usuario autenticado es el mismo que creo el artículo
        return $user->id === $article->user_id;
    }

    public function update(User $user, Article $article)
    {
        //Revisar si el usuario autenticado es el mismo que creo el artículo
        return $user->id === $article->user_id;
    }

    public function delete(User $user, Article $article)
    {
        //Revisar si el usuario autenticado es el mismo que creo el artículo
        return $user->id === $article->user_id;
    }

    public function published(?User $user, Article $article){
        if($article->status == 1){
            return true;
        }else{
            return false;
        }
    }
}
