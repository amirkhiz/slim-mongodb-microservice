<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 1.03.2018
 * Time: 11:20
 */

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Sirius\Validation\Validator;

class User extends Model
{
    protected $collection = 'users';

    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'username',
        'created_at',
        'updated_at',
    ];

    /**
     * @return \Sirius\Validation\Validator
     */
    public static function validator()
    {
        $validator = new Validator();
        $validator->add(
            [
                'first_name:First Name' => 'required',
                'last_name:Last Name'   => 'required',
                'email:Email'           => 'required | email',
                'username:Username'     => 'required',
            ]
        );

        return $validator;
    }
}