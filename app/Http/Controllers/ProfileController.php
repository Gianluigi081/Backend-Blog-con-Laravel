<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit(Profile $profile)
    {
        $this->authorize('view', $profile);
        
        return view('subscriber.profiles.edit', compact('profile'));
    }


    public function update(ProfileRequest $request, Profile $profile)
    {
        $this->authorize('update', $profile);

        $user = Auth::user();
        $current_image = $user->profile->photo;
        $split_url = explode('/', $current_image);
        $public_id = explode('.', $split_url[sizeof($split_url)-1]); 

        if($request->hasFile('photo')){
            //Eliminar foto anterior
            Cloudinary::destroy('Profiles/'.$public_id[0]);
            //Asignar nueva foto
            $photo = Cloudinary::upload($request['photo']->getRealPath(),[
                'folder' => 'Profiles',
            ])->getSecurePath();

        }else{
            $photo = $user->profile->photo;
        }

        //Asignar nombre y correo
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        //Asignar foto
        $user->profile->photo = $photo;

        //Guardar campos de usuario
        $user->save();
        //Guardar campos de perfil
        $user->profile->save();

        return redirect()->route('profiles.edit', $user->profile->id);
    }


}
