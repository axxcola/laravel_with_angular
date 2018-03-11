<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class user extends Model
{
    protected $table = 'users';
    protected $guarded = [];
    protected $primaryKey = 'id';

    public function signUp(Request $request)
    {
        $userName = $request->get('username');
        $pwd = $request->get('password');
        if (!($userName && $pwd)) {
            return response()->json(['success' => false, 'msg' => 'Username or password Invalid']);
        }
        //check if the username is already exists
        $userExists = $this->where('username', $userName)->exists();
        if ($userExists) {
            return response()->json(['success' => false, 'msg' => 'Username already used.']);
        }
        //hash password
        $pwd = Hash::make($pwd);

        $this->username = $userName;
        $this->password = $pwd;
        $this->save();
        return response()->json(['success' => true, 'msg' => 'Signed Up !']);
    }
}
