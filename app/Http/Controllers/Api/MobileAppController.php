<?php

namespace App\Http\Controllers\Api;

use App\Member;
use App\PushLog;
use App\Relative;
use App\User;
use Carbon\Carbon;
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
            'username' => 'required',
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
		if (!$user) {
			$user = Member::where('pid', '=', $user_name)->first();
		}

		if (!$user) {
			return response()->json([
				'success' => false,
				'error_message' => '用户不存在'
			]);
		}

        if ($user->pwd == strrev(md5($password))) {
            return response()->json([
                'success' => true,
                'result' => [
                    'userid' => $user->userid,
                    'username' => $user->uname,
                    'usertype' => $user->usertype,
                    'nickname' => $user->cname,
                    'mobile' => $user->tphone,
                    //'credits' => $user->
                    'hdpurl' => $user->picpath
                    //'xm' =>
                    //TODO find credits column
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error_message' => '密码错误'
            ]);
        }


    }

    public function postMessage(Request $request)
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

		$mid = Member::where('userid', $request->input('username'))->first()->id;
		$warn_list = \DB::connection('mysql_old')->table('data_warn_save')
			->where('userid', $mid)
			->where('type', '!=', 5)
			->orderBy('id', 'DESC');

        return response()->json([
            'success' => true,
            'result' => [
                'warnlist' => $warn_list
			]
        ]);
    }

	public function getPush(Request $request)
	{
		header("Content-Type: text/html; charset=utf-8");

		require_once(dirname(__FILE__) . '/JiulePush/' . 'IGt.Push.php');

		define('APPKEY','PHD9JWXNy89kmYY9NF7V92');
		define('APPID','7t2rQy5B0w9sXNZN6JJf2');
		define('MASTERSECRET','Gt19kYh3N88tMRODZp4rH2');
		define('HOST','http://sdk.open.api.igexin.com/apiex.htm');
		define('CID','');
//define('CID2','请输入ClientID');
		define('ALIAS',$request->input('userid'));


		$igt = new \IGeTui(HOST,APPKEY,MASTERSECRET);
//		$res = $igt->queryAlias(APPID, ALIAS);
//		dd($res);

//消息模版：
// 1.TransmissionTemplate:透传功能模板
// 2.LinkTemplate:通知打开链接功能模板
// 3.NotificationTemplate：通知透传功能模板
// 4.NotyPopLoadTemplate：通知弹框下载功能模板

//$template = IGtNotyPopLoadTemplateDemo();
//$template = IGtLinkTemplateDemo();
//$template = IGtNotificationTemplateDemo();
//$template = IGtTransmissionTemplateDemo();

		$template =  new \IGtNotificationTemplate();
		$template->set_appId(APPID);                      //应用appid
		$template->set_appkey(APPKEY);                    //应用appkey
		$template->set_transmissionType(1);               //透传消息类型
		$template->set_transmissionContent("测试离线");   //透传内容
		$template->set_title($request->input('title'));                     //通知栏标题
		$template->set_text($request->input('content'));        //通知栏内容
		$template->set_logo("logo.png");                  //通知栏logo
		$template->set_logoURL(public_path().'/images/logo.png'); //通知栏logo链接
		$template->set_isRing(true);                      //是否响铃
		$template->set_isVibrate(true);                   //是否震动
		$template->set_isClearable(true);                 //通知栏是否可清除

//个推信息体
		$message = new \IGtSingleMessage();

		$message->set_isOffline(true);//是否离线
		$message->set_offlineExpireTime(3600*12*1000);//离线时间
		$message->set_data($template);//设置推送消息类型
		$message->set_PushNetWorkType(0);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送
//接收方
		$target = new \IGtTarget();
		$target->set_appId(APPID);
//		$target->set_clientId(CID);
		$target->set_alias(ALIAS);

		$rep = $igt->pushMessageToSingle($message,$target);

		if ($rep['result'] == 'ok') {
			$pushlog = new PushLog();
			$pushlog->msgtitle = $request->input('title');
			$pushlog->msgcontent = $request->input('content');
			$pushlog->msgtype = $request->input('userid');
			$pushlog->msgsno = $rep['taskId'];
			$pushlog->msgtime = Carbon::now()->timestamp;
			$pushlog->save();
		}

		return $rep;
	}

	public function postQueryWatch(Request $request)
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
			'success' => true,
			'result' => [
				'hasWatch' => $member->status?false:true,
				'watchNumber' => $member->pid
			]
		]);
	}

    public function postUpdate(Request $request)
    {

        return response()->json([
            'success' => true,
            'result' => [
                'version' => 'undefined',
                'updatemsg' => 'undefined',
                'updateflag' => 'undefined',
                'updateurl' => 'undefined'
            ]
        ]);
        //TODO get the download link
    }

    public function postActivate(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'indexCode' => 'required|exists:mysql_old.member,pid',
            'username' => 'required',
            'phoneNumber' => 'required',
            'name1' => 'required',
            'phoneNumber1' => 'required',
            'name2' => 'required',
            'phoneNumber2' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error_message' => $validator->errors()->getMessages()]);
        }

        $pid = $request->input('indexCode');
        $userid = $request->input('username');
        $phone = $request->input('phoneNumber');

        $emergency_contact = $request->input('phoneNumber1');
        $emergency_contact2 = $request->input('name1');
        $emergency_phone = $request->input('phoneNumber2');
        $emergency_phone2 = $request->input('name2');

        $member = Member::where('pid', $pid)->first();
        $member->status = 0;
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


        $set1 = \DB::connection('mysql_old')->table('data')->where('userid', $member->id)
            ->where('heartrate', '!=', 0)
            ->orderBy('time', 'DESC')
            ->select(['heartrate', 'spo2'])
            ->first();

        $set2 = \DB::connection('mysql_old')->table('data')->where('userid', $member->id)
            ->orderBy('time', 'DESC')
            ->select(['id', 'activity', 'sleep_total_time'])
            ->first();


        $set3 = \DB::connection('mysql_old')->table('data_warn_save')
            ->where('userid', $member->id)
            ->where('type', '!=', 5)
            ->orderBy('id', 'DESC')
            ->first();

        $relative = Relative::where('mid', $member->id)->where('main', 1)->first();


        return response()->json([
            'success' => true,
            'result' => [
                'bloodOxygen' => $set1?$set1->spo2:null,
                'heartRate' => $set1?$set1->heartrate:null,
                'activity' => $set2?$set2->activity:null,
                'sleep' => ($set2->sleep_total_time >= 360)? '良好':'差',
                'urgentCall' => $relative->phone,
                'callPolice' => $set3? $set3->toArray():null,
                'lifeWarning' => null,
				'ecg' => null,
				'emotion' => null,
				'temperature' => null
            ]
        ]);
    }

    public function getTest(Request $request)
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


        $set1 = \DB::connection('mysql_old')->table('data')->where('userid', $member->id)
            ->where('heartrate', '!=', 0)
            ->orderBy('time', 'DESC')
            ->select(['heartrate', 'spo2'])
            ->first();

        $set2 = \DB::connection('mysql_old')->table('data')->where('userid', $member->id)
            ->orderBy('time', 'DESC')
            ->select(['id', 'activity', 'sleep_total_time'])
            ->first();


        $set3 = \DB::connection('mysql_old')->table('data_warn_save')
            ->where('userid', $userid)
            ->where('type', '!=', 5)
            ->orderBy('id', 'DESC')
            ->first();

        $relative = Relative::where('mid', $member->id)->where('main', 1)->first();


        return response()->json([
            'success' => true,
            'result' => [
                'bloodOxygen' => $set1->spo2,
                'heartRate' => $set1->heartrate,
                'activity' => $set2->activity,
                'sleep' => ($set2->sleep_total_time >= 360)? '良好':'差',
                'urgentCall' => $relative->phone,
                'callPolice' => $set3? $set3->toArray():null,
            ]
        ]);
    }

    public function postMemberData(Request $request){
			$mid = !empty($request->input('mid'))?$request->input('mid'):null;
			if($mid == null){
				$data=array();
				$data[0]['success']='fail';
				return response()->json($data);
			}else{
				$arr =  DB::connection('mysql_old')->select('select userid,longitude,latitude,c_type,type,time,gps_type,id,spo2,heartrate,breath,skin,wear_type,msg_send_flag from jl_data_warn where userid ='.$mid);
				$i = 0;
				$data = array();
				foreach($arr as $v){
					$uname=DB::connection('mysql_old')->select('select id,sex,pid,uname,tphone,phone,userid,rphone1,rphone2 from jl_member where id="'.$v->userid.'"');
					$name = DB::connection('mysql_old')->select('select name,phone,relationship,main from jl_member_relatives where mid="'.$v->userid.'"');
					$log = DB::connection('mysql_old')->select('select * from jl_warn_log where userid="'.$v->userid.'" limit 10');
					if(!empty($log)){
						$k=0;
						$data[$i]['log'][0]['success']=1;
						foreach($log as $val){
							$wlog = DB::connection('mysql_old')->select('select type,time from jl_data_warn_save where id="'.$val->wid.'"');
							switch($wlog[0]->type) {
								case '1' : $type =  "紧急呼叫";break;
								case '2' : $type =  "预警";break;
								case '3' : $type =  "报警";break;
								case '4' : $type =  "跌倒";break;
								default : $type =  "未知";break;
							}
							$data[$i]['log'][$k]['time_w']=date('Y/m/d H:i:s',$wlog[0]->time);
							$data[$i]['log'][$k]['type']=$type;
							$data[$i]['log'][$k]['time']=date('Y/m/d H:i:s',$val->time);
							$data[$i]['log'][$k]['mtype']=$val->type==0?'完成':'处理';
							$data[$i]['log'][$k]['admin']=$val->admin;
							$data[$i]['log'][$k]['mark']=$val->mark;
							$k++;
						}
					}else{
						$data[$i]['log'][0]['success']=0;
					}
				}
					$data[$i]['icon']="house";
 					
					if($v->c_type== 1) $data[$i]['icon'] = "housey";
					if($v->c_type == 0) $data[$i]['icon'] = "houseg";
					if(!empty($name)){
						$data[$i]['relationship'][0]['name']=$name[0]->name;
						$data[$i]['relationship'][0]['phone']=$name[0]->phone;
						$data[$i]['relationship'][1]['name']=$name[1]->name;
						$data[$i]['relationship'][1]['phone']=$name[1]->phone;
					}else{
						$data[$i]['relationship'][0]['name']='没有数据';
						$data[$i]['relationship'][0]['phone']='没有数据';
						$data[$i]['relationship'][1]['name']='没有数据';
						$data[$i]['relationship'][1]['phone']='没有数据';
						
					}
					$data[$i]['uname'] = $uname[0]->uname?$uname[0]->uname:"";
					$data[$i]['ccid'] = $uname[0]->pid?$uname[0]->pid:"";
					$data[$i]['latitude'] = $v->latitude;
					$data[$i]['longitude'] = $v->longitude;
					$data[$i]['type'] = $v->type;
					$data[$i]['c_type'] = $v->c_type;
					$data[$i]['msg_send_flag'] = $v->msg_send_flag;
					$data[$i]['spo2'] = $v->spo2;
					$data[$i]['wid'] = $v->userid;
					$data[$i]['tel'] = $uname[0]->phone?$uname[0]->phone:"没有数据";
					$data[$i]['sex'] = $uname[0]->sex;
					$data[$i]['userid'] = $uname[0]->userid?$uname[0]->userid:"没有数据";
					$data[$i]['heartrate'] = $v->heartrate;
					$data[$i]['breath'] = $v->breath;
					$data[$i]['skin'] = $v->skin;
					$data[$i]['wear_type'] = $v->wear_type==1?"是":"否";
					$data[$i]['time'] = date("Y/m/d H:i:s",$v->time);
					switch($v->gps_type) {
						case 0 : $data[$i]['gps_type'] =  "GPRS";break;
						case 1 : $data[$i]['gps_type'] =  "GPS";break;
						case 2 : $data[$i]['gps_type'] =  "定位失败";break;
						case 11 : $data[$i]['gps_type'] =  "GPS";break;
						default : $data[$i]['gps_type'] =  "定位失败";
					}
					
					switch($v->type) {
						case '1' : $data[$i]['type_str'] =  "紧急呼叫";break;
						case '2' : $data[$i]['type_str'] =  "预警";break;
						case '3' : $data[$i]['type_str'] =  "报警";break;
						case '4' : $data[$i]['type_str'] =  "跌倒";break;
						default : $data[$i]['type_str'] =  "未知";break;
					}
					switch($v->c_type) {
						case '0' : $data[$i]['c_type'] =  "问题解决";break;
						case '1' : $data[$i]['c_type'] =  "处理中";break;
						case '2' : $data[$i]['c_type'] =  "未处理";break;
						default : $data[$i]['c_type'] =  "未知";break;
					}
					$data[$i]['rphone1'] = $uname[0]->rphone1;
					$data[$i]['rphone2'] = $uname[0]->rphone2;
					$i++;
				}
			return response()->json($data);
		}
	
	
	public function postWarnData(Request $request)
    {
			$time = time()-24*3600;
			
			$smsArr = array();
			$arr = DB::connection('mysql_old')->select('select mid,userid,longitude,latitude,c_type,type,time,gps_type,spo2,heartrate,breath,skin,wear_type,msg_send_flag from jl_data_warn where (c_type!=0 or time2>"'.$time.'") and type!=5 order by time desc');
			$s=0;
			foreach($arr as $val){
				$rs = DB::connection('mysql_old')->select('select pid,saled,registed from jl_product_ext where mid="'.$val->userid.'"');
				if($rs[0]->saled=='1'){
					if($rs[0]->registed=='-1'){
						unset($arr[$s]);
					}
				}else{
					unset($arr[$s]);
				}
				$s++;
			}
			
			if(empty($arr)){
				$data=array();
				$data[0]['success']='fail';
				return response()->json($data);
			}else{
				$i = 0;
				$data = array();
				foreach($arr as $v){
					
					$uname=DB::connection('mysql_old')->select('select id,uname,sex,pid,tphone,phone,userid,rphone1,rphone2 from jl_member where id="'.$v->userid.'"');
					$name = DB::connection('mysql_old')->select('select name,phone,relationship,main from jl_member_relatives where mid="'.$v->userid.'"');
					$data[$i]['icon']="house";
 					
					if($v->c_type== 1) $data[$i]['icon'] = "housey";
					if($v->c_type == 0) $data[$i]['icon'] = "houseg";
					if(!empty($name)){
						$data[$i]['relationship'][0]['name']=$name[0]->name;
						$data[$i]['relationship'][0]['phone']=$name[0]->phone;
						$data[$i]['relationship'][1]['name']=$name[1]->name;
						$data[$i]['relationship'][1]['phone']=$name[1]->phone;
					}else{
						$data[$i]['relationship'][0]['name']='没有数据';
						$data[$i]['relationship'][0]['phone']='没有数据';
						$data[$i]['relationship'][1]['name']='没有数据';
						$data[$i]['relationship'][1]['phone']='没有数据';
						
					}					
					
					
					$data[$i]['uname'] = $uname[0]->uname?$uname[0]->uname:"";
					$data[$i]['ccid'] = $uname[0]->pid?$uname[0]->pid:"";
					$data[$i]['latitude'] = $v->latitude;
					$data[$i]['longitude'] = $v->longitude;
					$data[$i]['type'] = $v->type;
					$data[$i]['c_type'] = $v->c_type;
					$data[$i]['msg_send_flag'] = $v->msg_send_flag;
					$data[$i]['spo2'] = $v->spo2;
					$data[$i]['wid'] = $v->userid;
					$data[$i]['tel'] = $uname[0]->phone?$uname[0]->phone:"没有数据";
					$data[$i]['sex'] = $uname[0]->sex;
					$data[$i]['userid'] = $uname[0]->userid?$uname[0]->userid:"没有数据";
					$data[$i]['heartrate'] = $v->heartrate;
					$data[$i]['breath'] = $v->breath;
					$data[$i]['skin'] = $v->skin;
					$data[$i]['wear_type'] = $v->wear_type==1?"是":"否";
					$data[$i]['time'] = date("Y/d/m H:i:s",$v->time);
					switch($v->gps_type) {
						case 0 : $data[$i]['gps_type'] =  "GPRS";break;
						case 1 : $data[$i]['gps_type'] =  "GPS";break;
						case 2 : $data[$i]['gps_type'] =  "定位失败";break;
						case 11 : $data[$i]['gps_type'] =  "GPS";break;
						default : $data[$i]['gps_type'] =  "定位失败";
					}
					
					switch($v->type) {
						case '1' : $data[$i]['type_str'] =  "紧急呼叫";break;
						case '2' : $data[$i]['type_str'] =  "预警";break;
						case '3' : $data[$i]['type_str'] =  "报警";break;
						case '4' : $data[$i]['type_str'] =  "跌倒";break;
						default : $data[$i]['type_str'] =  "未知";break;
					}
					switch($v->c_type) {
						case '0' : $data[$i]['c_type'] =  "问题解决";break;
						case '1' : $data[$i]['c_type'] =  "处理中";break;
						case '2' : $data[$i]['c_type'] =  "未处理";break;
						default : $data[$i]['c_type'] =  "未知";break;
					}
					$data[$i]['rphone1'] = $uname[0]->rphone1;
					$data[$i]['rphone2'] = $uname[0]->rphone2;
					$i++;
					
				}
			}
			$data[0]['success']='success';
			return response()->json($data);
    }
	
	public function postCancelWarn(Request $request){
			$id = !empty($request->input('id'))?$request->input('id'):null;
			$mark = !empty($request->input('mark'))?$request->input('mark'):null;
			$act = !empty($request->input('act'))?$request->input('act'):null;
            $wlogid = !empty($request->input('wlogid'))?$request->input('wlogid'):null;
			if($act == 'cancel'){
				if($id === null){
					$rs['sucess']=false;
					$rs['data']="数据提交失败，请稍后重试！";
					$rs['id']=$id;
				}else{
					$warnInfo = DB::connection('mysql_old')->select('select c_type,userid from jl_data_warn where userid="'.$id.'"');
					if($warnInfo[0]->c_type != 1){
						$rs['sucess'] = false;
						$rs['data'] = "请先对报警进行处理!";
						$rs['id']=$id;
						return response()->json($rs);
					}
					$warnId = DB::connection('mysql_old')->select('select id from jl_data_warn_save where userid="'.$id.'" order by id desc limit 1');
					$data=array();
					$data['wid'] = $warnId[0]->id;
					$data['time'] = time();
					$data['admin'] = \Auth::user()->email;
					$data['mark'] = $mark;
					$data['type'] = 0;
					$in_flag=DB::connection('mysql_old')->insert('insert into jl_warn_log set userid='.$id.',wid='.$data['wid'].',time='.$data['time'].',admin="'.$data['admin'].'",mark="'.$data['mark'].'",type='.$data['type']);
					if($in_flag!== true){
						$rs['sucess']=false;
						$rs['data']="数据提交失败，请稍后重试！";
						$rs['id']=$id;
					}else{
						$up_flag=DB::connection('mysql_old')->update('update jl_data_warn set c_type=0,time2='.$data['time'].' where userid="'.$id.'"');
						$rs['sucess']=true;
						$rs['data']="提交成功！";
						$rs['id']=$id;
					}
				}
				return response()->json($rs);
			}else if($act == 'solve'){
				if($id === null){
					$rs['sucess']=false;
					$rs['data']="数据提交失败，请稍后重试！";
					$rs['id']=$id;
				}else{
					$warnId = DB::connection('mysql_old')->select('select id from jl_data_warn_save where userid="'.$id.'" order by id desc limit 1');
					$data=array();
					$data['wid'] = $warnId[0]->id;
					$data['time'] = time();
					$data['admin'] = \Auth::user()->email;
					$data['mark'] = $mark;
					$data['type'] = 1;
					$in_flag=DB::connection('mysql_old')->insert('insert into jl_warn_log set userid='.$id.',wid='.$data['wid'].',time='.$data['time'].',admin="'.$data['admin'].'",mark="'.$data['mark'].'",type='.$data['type']);
					if($in_flag!== true){
						$rs['sucess']=false;
						$rs['data']="数据提交失败，请稍后重试！";
						$rs['id']=$id;
					}else{
						$up_flag=DB::connection('mysql_old')->update('update jl_data_warn set c_type=1 where userid="'.$id.'"');
						$rs['sucess']=true;
						$rs['data']="提交成功！";
						$rs['id']=$id;
					}
				}
				return response()->json($rs);				
			}
		}
}
