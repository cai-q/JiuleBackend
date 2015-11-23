<?php

namespace App\Http\Controllers\Api;

use App\Member;
use App\Relative;
use App\User;
use Illuminate\Http\Request;
use \Validator;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MobileAppController extends Controller
{
    public function postLogin(Request $request)
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

        \Log::error('123456');

        $user_name = $request->input('username');
        $password = $request->input('password');

        $user = Member::where('userid', '=', $user_name)->first();
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
        return response()->json([
            'version' => 'undefined',
            'updatemsg' => 'undefined',
            'updateflag' => 'undefined',
            'updateurl' => 'undefined'
        ]);
        //TODO get the download link
    }

    public function postActivate(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'indexCode' => 'required|exists:mysql_old.member.pid',
            'username' => 'required',
            'phoneNumber' => 'required',
            'name1' => 'required',
            'phoneNumber1' => 'required',
            'name2' => 'required',
            'phoneNumber2' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->getMessages()]);
        }

        $pid = $request->input('indexCode');
        $userid = $request->input('username');
        $phone = $request->input('phoneNumber');

        $emergency_contact = $request->input('phoneNumber1');
        $emergency_contact2 = $request->input('name1');
        $emergency_phone = $request->input('phoneNumber2');
        $emergency_phone2 = $request->input('name2');

        $member = Member::where('pid', $pid)->first();
        $member->status = 1;
        $member->userid = $userid;
        $member->phone = $phone;
        $member->save();

        $relative = Relative::where('mid', $member->id)->where('main', 1)->first();
        if (!$relative) {
            $relative = new Relative();
        }
        $relative->name = $emergency_contact;
        $relative->phone = $emergency_phone;
        $relative->mid = $member->id;
        $relative->main = 1;
        $relative->save();

        $relative = Relative::where('mid', $member->id)->where('main', 0)->first();
        if (!$relative) {
            $relative = new Relative();
        }
        $relative->name = $emergency_contact2;
        $relative->phone = $emergency_phone2;
        $relative->mid = $member->id;
        $relative->main = 0;
        $relative->save();

        return response()->json([
            'success' => true
        ]);
    }

    public function postUserIndex(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|exists:mysql_old.member,userid',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error_message' => $validator->errors()->getMessages()
            ]);
        }

        $userid = $request->input('username');
        $member = Member::where('userid', $userid)->first();

        return response()->json([
            'bloodOxygen' => '',
            'heartRate' => '',
            'activity' => '',
            'sleep' => '',
            'urgentCall' => '',
            'callPolice' => '',
            'lifeWarning' => ''
        ]);
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
//        $a = Member::join('data_warn_save', 'data_warn_save.userid', '=', 'member.id')->select('*')->addSelect('member.userid')->first();
//        dd($a);

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

        $user = Member::where('userid', '=', $user_name)->first();
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
}
