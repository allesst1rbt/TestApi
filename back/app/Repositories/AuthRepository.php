<?php


namespace App\Repositories;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Exception;

class AuthRepository implements AuthRepositoryInterface
{
    public function createUser($data){
        try {
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->password = bcrypt($data->password);
            $user->save();
        }catch (\Exception $exception){
            throw new \Exception("Error on creating user");
        }


    }
}
