<?php

namespace App\Http\Controllers\Management;

use App\Member;
use App\User;
use App\Warning;
use Carbon\Carbon;
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
            $items = Member::join('data_warn_save', 'data_warn_save.userid', '=', 'member.id')->select('*')->addSelect('member.userid')->paginate(10);
        } else {
            $items = Member::join('data_warn_save', 'data_warn_save.userid', '=', 'member.id')->select('*')->addSelect('member.userid')
                ->where('member.fid', \Auth::user()->id)->paginate(10);
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
        $option = $request->input('select');

        $init_key = $request->input('key');
        $key = '%' . $request->input('key') . '%';
        $start = $request->input('start');
        $end = $request->input('end');

        if ($option == 'userid') {
            if (\Auth::user()->user_type == 0) {
                $items = Member::join('data_warn_save', 'data_warn_save.userid', '=', 'member.id')
                    ->select('*')->addSelect('member.userid')
                    ->where('member.userid', 'like', $key);
            } else {
                $items = Member::join('data_warn_save', 'data_warn_save.userid', '=', 'member.id')
                    ->select('*')->addSelect('member.userid')
                    ->where('member.userid', 'like', $key)
                    ->where('member.fid', '=', \Auth::user()->id);
            }
        } elseif ($option == 'pid') {

            if (\Auth::user()->user_type == 0) {
                $items = Member::join('data_warn_save', 'data_warn_save.userid', '=', 'member.id')
                    ->select('*')->addSelect('member.userid')
                    ->where('member.pid', 'like', $key);
            } else {
                $items = Member::join('data_warn_save', 'data_warn_save.userid', '=', 'member.id')
                    ->select('*')->addSelect('member.userid')
                    ->where('member.pid', 'like', $key)
                    ->where('member.fid', '=', \Auth::user()->id);
            }
        } elseif ($option == 'time') {
            if (\Auth::user()->user_type == 0) {
                $items = Member::join('data_warn_save', 'data_warn_save.userid', '=', 'member.id')
                    ->select('*')->addSelect('member.userid')
                    ->where('data_warn_save.time', '>=', strtotime($start))
                    ->where('data_warn_save.time', '<=', strtotime($end));
            } else {
                $items = Member::join('data_warn_save', 'data_warn_save.userid', '=', 'member.id')
                    ->select('*')->addSelect('member.userid')
                    ->where('data_warn_save.time', '>=', strtotime($start))
                    ->where('data_warn_save.time', '<', strtotime($end) + 3600 * 24);
            }
        } else {
            $item = [];
        }

        return view('warning.index')->with([
            'items' => $items->paginate(10),
            'key' => $init_key,
            'start' => $start,
            'end' => $end,
            'select' => $option
        ]);
    }

    public function getGaode()
    {
        return view('warning.gaode');
    }
}
