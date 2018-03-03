<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 1.03.2018
 * Time: 18:28
 */

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'first_name' => $user->firstName,
            'last_name'  => $user->lastName,
            'email'      => $user->email,
            'username'   => $user->username,
        ];
    }
}