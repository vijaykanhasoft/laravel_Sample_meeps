<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Email;

class UserController extends Controller {

    public function index(Request $request) {
        $limit = $request->get('length');
        $start = $request->get('start');
        $draw = $request->get('draw');
        $sort_by = $t1 = $request->get('column_name');
        $sort_order = $request->get('order');
        $search = $request->get('search');
        $show_in_active = $request->get('show_in_active');

        $params = array('limit' => $limit, 'start' => $start, 'sort_by' => $sort_by, 'sort_order' => $sort_order, 'search' => $search, 'show_in_active' => $show_in_active);

        $user_list = Users::get_user_list($params);
        $response = array(
            'success' => true,
            "data" => $user_list['data'],
            "draw" => $draw,
            "recordsFiltered" => $user_list['count'],
            "recordsTotal" => $user_list['count']
        );
        if (count($user_list)) {
            return json_encode($response);
        } else {
            return json_encode(array('success' => false));
        }
    }

    public function create(Request $request) {
        $data = array();

        $name = $request->get('user_name');
        $email = $request->get('email');
        $password = $request->get('password');
        $company_id = $request->get('company_id');
        $user_id = $request->get('user_id');
        $userWithEmail = Users::where(array('email' => $email))->first();
        if (count($userWithEmail) > 0 && $userWithEmail->id != $user_id) {
            return json_encode(array('success' => false, 'email_exists' => true));
        }

        if (isset($name) && !empty($name)) {
            $data['name'] = $request->get('user_name');
        }
        if (isset($email) && !empty($email)) {
            $data['email'] = $request->get('email');
        }
        if (isset($password) && !empty($password)) {
            $data['password'] = md5($request->get('password'));
        }
        if (isset($company_id) && !empty($company_id)) {
            $data['company_id'] = $request->get('company_id');
        }

        if (!empty($user_id)) {
            $result = Users::update_user($data, $user_id);
        } else {
            $result = Users::create_user($data);
            if ($result) {
                $login_url = url('/') . '/#/login';
                $subject = "Laravel - AngularJs Sample. Account Created";
                $body = "Dear {$data['name']} <br/><br/>";
                $body .= "Admin has set up your account for Laravel Sample, Please find the login details below.";
                $body .= "<br/>Url : {$login_url}";
                $body .= "<br/>Email : {$request->get('email')}";
                $body .= "<br/>Password : {$request->get('password')}";
                $to = $data['email'];
                Email::send_email($subject, $body, $to);
            }
        }
        if (count($result)) {
            return json_encode(array('success' => true, 'data' => $data));
        } else {
            return json_encode(array('success' => false));
        }
    }

    public function delete(Request $request) {
        $user_id = $request->get('user_id');
        $is_active = $request->get('is_active');
        $result = Users::delete_user($user_id, $is_active);
        if (count($result)) {
            return json_encode(array('success' => true));
        } else {
            return json_encode(array('success' => false));
        }
    }

    public function user_detail(Request $request) {
        $user_id = $request->get('user_id');
        $user_detail = Users::get_user($user_id);
        if (count($user_detail)) {
            return json_encode(array('success' => true, 'data' => $user_detail));
        } else {
            return json_encode(array('success' => false));
        }
    }

    public function reset_user_password(Request $request) {
        $data = array();
        $user_id = $request->get('user_id');
        $data['password'] = md5($request->get('password'));
        $result = Users::update_user($data, $user_id);
        if (count($result)) {
            return json_encode(array('success' => true));
        } else {
            return json_encode(array('success' => false));
        }
    }

    public function update_user_password(Request $request) {
        $data = array();
        $user_id = $request->get('user_id');
        $user_detail = Users::get_user($user_id);
        if (count($user_detail)) {
            $old_password = md5($request->get('old_password'));
            if ($old_password !== $user_detail->password) {
                return json_encode(array('success' => false, 'message' => 'no_match'));
            }
            $data['password'] = md5($request->get('password'));
            $result = Users::update_user($data, $user_id);
            if (count($result)) {
                return json_encode(array('success' => true));
            } else {
                return json_encode(array('success' => false));
            }
        } else {
            return json_encode(array('success' => false));
        }
    }

}
