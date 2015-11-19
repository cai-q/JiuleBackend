<?php

namespace App\Http\Controllers\Api;

use App\Member;
use App\User;
use Illuminate\Http\Request;
use \Validator;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MobileAppController extends Controller
{
    public function getLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|exists:mysql_old.member,userid',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error_message' => $validator->errors()->getMessages()
            ]);
        }

        $user_name = $request->input('username');
        $password = $request->input('password');

        $user = Member::where('userid', '=', $user_name);
        if ($user->pwd == strrev(md5($password))) {
            return response()->json([
                'userid' => $user->userid,
                'username' => $user->uname,
                'usertype' => $user->usertype,
                'nickname' => $user->cname,
                'mobile' => $user->tphone
                //'credits' => $user->
                //'hdpurl' => $user->
                //'xm' =>
                //TODO find credits column
            ]);
        } else {
            return response()->json([
                'error' => '密码错误'
            ]);
        }


    }

    public function postMessage(Request $request)
    {
        //TODO download new message
    }

    public function postUpdate(Request $request)
    {
        //TODO get the download link
    }

    public function postActivate(Request $request)
    {
        //TODO activate a watch
    }

    public function postUserIndex(Request $request)
    {
        //TODO get the index information
    }

    public function getTest(Request $request)
    {
//        $a = DB::connection('mysql_old')->table('member')->join('product_ext', 'member.pid', '=', 'product_ext.pid')->get();
//        dd($a);

//        $a = DB::connection('mysql_old')
//            ->table('product_ext')
//            ->where('pid', '1262710000181')
//            ->first()->saled;
//        dd($a);

//        dd(User::where('parent_id', 2)->select('id')->get()->pluck('id')->toArray());
        $a = Member::join('data_warn_save', 'data_warn_save.userid', '=', 'member.id')->first();
        dd($a);
    }
}
