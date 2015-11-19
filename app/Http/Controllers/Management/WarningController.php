<?php

namespace App\Http\Controllers\Management;

use App\Member;
use App\User;
use App\Warning;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WarningController extends Controller
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
            $items = Warning::paginate(10);
        } else {
//            $sub_companies = User::where('parent_id', \Auth::user()->id)
//                ->select('id')
//                ->get()
//                ->pluck('id')
//                ->toArray();

            $members = Member::where('fid', \Auth::user()->id)
                ->select('id')
                ->get()
                ->pluck('id')
                ->toArray();

            $items = Warning::whereIn('userid', $members)->paginate(10);

        }

        return view('warning.index')->with([
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
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
            $items = Member::join('data_warn_save', 'data_warn_save.userid', '=', 'member.id')
                ->where('member.userid', 'like', $key)
                ->orWhere('member.pid', 'like', $key);
        } else {
            $items = Member::join('data_warn_save', 'data_warn_save.userid', '=', 'member.id')
                ->where('member.userid', 'like', $key)
                ->orWhere('member.pid', 'like', $key)
                ->where('member.fid', '=', \Auth::user()->id);
        }

        return view('watch.index')->with([
            'items' => $items->paginate(10)
        ]);
    }
}
