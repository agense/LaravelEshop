<?php
namespace App\Services;

use App\Exceptions\ModelModificationException;

class UserService {

    /**
     * Update user account
     * @return App\Model\User
     */
    public function updateAccount(){
        try{
            $user = auth()->user();
            $user->fill(request()->except('password', 'password_confirmation'));

            if(request()->filled('password')){
                $user->password = bcrypt(request()->password);
            }
            $user->save();
            return $user;
        }catch(\Exception $e){
            throw new ModelModificationException($e->getMessage());
        }
    }
}