<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Email;
use DB;

class Users extends Model {

    protected $fillable = ['name', 'email', 'password', 'remember_token', 'created_at', 'updated_at', 'is_admin', 'password_reset_token', 'is_active'];

    public static function create_user($data = array()) {
        $insert = Users::create($data);
        if (isset($insert)) {
            return true;
        } else {
            return false;
        }
    }

    public static function get_user_list($params = array()) {
        $totalcountQry = DB::table('users')
                ->select('users.*');
        if (isset($params['search']) && !empty($params['search'])) {
            $totalcountQry->where(function ($query) use ($params) {
                $query->orWhere('name', 'like', '%' . $params['search'] . '%')
                        ->orWhere('email', 'like', '%' . $params['search'] . '%');
            });
        }
        if (empty($params['show_in_active'])) {
            $totalcountQry->Where('is_active', '=', 1);
        }
        $totalcount = $totalcountQry->get();
        $usersQry = DB::table('users')
                ->select('users.*');
        if (isset($params['search']) && !empty($params['search'])) {
            $usersQry->where(function ($query) use ($params) {
                $query->orWhere('name', 'like', '%' . $params['search'] . '%')
                        ->orWhere('email', 'like', '%' . $params['search'] . '%');
            });
        }
        if (empty($params['show_in_active'])) {
            $usersQry->Where('is_active', '=', 1);
        }
        $usersQry->orderBy($params['sort_by'], $params['sort_order'])
                ->offset($params['start'])
                ->limit($params['limit']);
        $users = $usersQry->get();
        if (isset($users)) {
            return array('data' => $users, 'count' => count($totalcount));
        } else {
            return false;
        }
    }

    public static function get_user($id = '') {
        $user = DB::table('users')
                ->select('users.*')
                ->Where('users.id', '=', $id)
                ->get()
                ->first();
        if (isset($user)) {
            return $user;
        } else {
            return false;
        }
    }

    public static function update_user($data = array(), $id = '') {
        $result = Users::find($id)->update($data);
        if (isset($result)) {
            return true;
        } else {
            return false;
        }
    }

    public static function delete_user($id = '', $is_active = 0) {
        $data = array('is_active' => $is_active);
        $result = Users::find($id)->update($data);
        if (isset($result)) {
            return true;
        } else {
            return false;
        }
    }

}
