<?php

namespace App\Http\Controllers\Management;

use App\Member;
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
        return view('watch.create');
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
}
