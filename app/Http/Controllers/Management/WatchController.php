<?php

namespace App\Http\Controllers\Management;

use App\Member;
use App\Relative;
use App\User;
use App\Watch;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class WatchController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::user()->user_type == 0) {
            $items = Member::paginate(10);
        } else {
            $items = Member::where('fid', '=', \Auth::user()->id)->paginate(10);
        }
        return view('watch.index')->with([
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $self_as_parent = false;
        if (\Auth::user()->user_type == 0) {
            $parents = User::where('user_type', 1)->get();
        } else {
            $parents = [\Auth::user()];
            $self_as_parent = \Auth::user();
        }
        return view('watch.create')->with([
            'parents' => $parents,
            'self_as_parent' => $self_as_parent
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'pid' => 'required|exists:mysql_old.member',
            'uname' => 'required',
            'emergency_contact' => 'required',
            'emergency_contact2' => 'required',
            'emergency_phone' => 'required',
            'emergency_phone2' => 'required',
            'fid' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $pid = $request->input('pid');
        $umane = $request->input('uname');
        $fid = $request->input('fid');

        $emergency_contact = $request->input('emergency_contact');
        $emergency_contact2 = $request->input('emergency_contact2');
        $emergency_phone = $request->input('emergency_phone');
        $emergency_phone2 = $request->input('emergency_phone2');

        $member = Member::where('pid', $pid)->first();
        $member->uname = $umane;
        $member->fid = $fid;
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

        return redirect()->back()->with('success', true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $member = Member::find($id);
        $contact1 = Relative::where('mid', $id)->where('main', 1)->first();
        $contact2 = Relative::where('mid', $id)->where('main', 0)->first();

        $self_as_parent = false;
        if (\Auth::user()->user_type == 0) {
            $parents = User::where('user_type', 1)->get();
        } else {
            $parents = [\Auth::user()];
            $self_as_parent = \Auth::user();
        }

        return view('watch.edit')->with([
            'member' => $member,
            'contact1' => $contact1,
            'contact2' => $contact2,
            'parents' => $parents,
            'self_as_parent' => $self_as_parent
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'pid' => 'required|exists:mysql_old.member',
            'uname' => 'required',
            'emergency_contact' => 'required',
            'emergency_contact2' => 'required',
            'emergency_phone' => 'required',
            'emergency_phone2' => 'required',
            'fid' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $pid = $request->input('pid');
        $uname = $request->input('uname');
        $fid = $request->input('fid');

        $emergency_contact = $request->input('emergency_contact');
        $emergency_contact2 = $request->input('emergency_contact2');
        $emergency_phone = $request->input('emergency_phone');
        $emergency_phone2 = $request->input('emergency_phone2');

        $member = Member::where('pid', $pid)->first();
        $member->uname = $uname;
        $member->fid = $fid;
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

        return redirect()->back()->with('success', true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getSearch(Request $request)
    {
        $init_key = $request->input('key');
        $key = '%' . $request->input('key') . '%';

        if (\Auth::user()->user_type == 0) {
            $items = Member
                ::where('pid', 'like', $key)
                ->orWhere('userid', 'like', $key);
        } else {
            $items = Member
                ::where('pid', 'like', $key)
                ->orWhere('userid', 'like', $key)
                ->where('fid', '=', \Auth::user()->id);
        }


        return view('watch.index')->with([
            'items' => $items->paginate(10),
            'key' => $init_key
        ]);
    }

    public function getActivate(Request $request)
    {
        $id = $request->input('pid');
        $member = Member::find($id);
        $member->status = 0;
        if (\Auth::user()->user_type != 0) {
            $member->fid = \Auth::user()->id;
        }
        $member->save();

        return redirect()->back()->with([
            'success' => true
        ]);
    }

    public function getMultipleCreate(Request $request)
    {
        return view('watch.multiple_create');
    }

    public function postMultipleCreate(Request $request)
    {
        $excel = $request->file('watch');
        $target = $excel->move(storage_path(), 'test.xslt');

        \Excel::load($target, function ($reader) {
            $array = $reader->get()->toArray();
            $result = [];
            foreach ($array as $item) {
                if ($item[0]) {
                    $result []= $item[0];
                }
            }

            foreach ($result as $item) {
                if ($member = Member::where('pid', intval($item))->first()) {
                    $member->fid = \Auth::user()->id;
                    $member->uname = \Auth::user()->contact_name;

                    $relative = Relative::where('mid', $member->id)->where('main', 1)->first();
                    if (!$relative) {
                        $relative = new Relative();
                    }
                    $relative->name = \Auth::user()->contact_name;
                    $relative->phone = \Auth::user()->contact_phone;
                    $relative->mid = $member->id;
                    $relative->main = 1;
                    $relative->save();


                    $member->save();
                }
            }
        });

        if (\Auth::user()->user_type == 0) {
            $items = Member::paginate(10);
        } else {
            $items = Member::where('fid', '=', \Auth::user()->id)->paginate(10);
        }

        return view('watch.index')->with(['success' => true, 'items' => $items]);
    }

    public function getSendMessageToCompany(Request $request)
    {

    }

    public function getSendMessageToUser(Request $request)
    {

    }

    protected function sendMsg($msg,$to){

        $SpCode='203192';
        $LoginName='wh_jl';
        $Password='jl0807';
        $UserNumber=trim($to);
        $content = $msg;
        $content = iconv("utf-8","GBK//IGNORE",$content);
        //$content = rawurlencode($content);
        $url="http://hb.ums86.com:8899/sms/Api/Send.do?SpCode=".$SpCode."&LoginName=".$LoginName."&Password=".$Password."&MessageContent=".$content."&UserNumber=".$UserNumber."&SerialNumber=&ScheduleTime=&f=1";
        //echo $url;
        @$status = file_get_contents($url);
        //echo $status;
        //记录

        \DB::connection('mysql_old')->table('smslog1')->insert([
            'phone' => $to,
            'text' => $msg,
            'time' => time(),
            'status' => iconv("GBK","utf-8//IGNORE",$status),
            'send' => $status
        ]);
    }
}
