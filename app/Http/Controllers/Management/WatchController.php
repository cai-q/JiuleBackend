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
        if (\Auth::user()->usertype == 0) {
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

        $relative = new Relative();
        $relative->name = $emergency_contact;
        $relative->phone = $emergency_phone;
        $relative->mid = $member->id;
        $relative->main = 1;
        $relative->save();

        $relative = new Relative();
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
        $relative->name = $emergency_contact;
        $relative->phone = $emergency_phone;
        $relative->mid = $member->id;
        $relative->main = 1;
        $relative->save();

        $relative = Relative::where('mid', $member->id)->where('main', 0)->first();
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
        $key = '%' . $request->input('key') . '%';

        if (\Auth::user()->user_type == 0) {
            $items = Member
                ::where('pid', 'like', $key)
                ->orWhere('userid', 'like', $key);
        } else {
            $items = Member
                ::where('pid', 'like', $key)
                ->orWhere('userid', 'like', $key)
                ->where('parent_id', '=', \Auth::user()->id);
        }


        return view('watch.index')->with([
            'items' => $items->paginate(10)
        ]);
    }

    public function getActivate(Request $request)
    {
        $pid = $request->input('pid');
        $member = Member::where('pid', $pid);
        $member->status = 0;
        $member->save();

        return redirect()->back()->with([
            'success' => true
        ]);
    }
}
