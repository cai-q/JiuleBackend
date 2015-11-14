<?php

namespace App\Http\Controllers\Management;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
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
            $items = User::where('id', '>', 1);
        } else {
            $items = User::where('parent_id', \Auth::user()->id);
        }

        return view('company.index')->with([
            'items' => $items->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\Auth::user()->user_type == 0) {
            $parents = User::where('user_type', 1)->get();
        } else {
            $parents = \Auth::user()->get();
        }

        return view('company.create')->with([
            'parents' => $parents
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
            'serial' => 'required',
            'email' => 'required|unique:users',
            'name' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $list = [
            'name',
            'email',
            'serial',
            'parent_id',
            'contact_name',
            'contact_phone'
        ];

        $user = new User();
        foreach ($list as $enum) {
            if ($request->has($enum)) {
                $user->$enum = $request->input($enum);
            }
        }

        $user->password = bcrypt($request->input('password'));
        $user->user_type = 1;
        $user->save();

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
        return view('company.edit')->with([
            'item' => User::find($id)
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
        $list = [
            'address',
            'certificate',
            'contact_name',
            'contact_phone'
        ];

        $user = User::find($id);
        foreach ($list as $enum) {
            if ($request->has($enum)) {
                $user->$enum = $request->input($enum);
            }
        }

        $user->save();

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
        User::find($id)->delete();

        User::where('parent_id', $id)->delete();//删除所有子级企业

        return redirect()->back()->with([
            'success' => true
        ]);
    }

    public function getSearch(Request $request)
    {
        $key = '%' . $request->input('key') . '%';

        if (\Auth::user()->user_type == 0) {
            $items = User
                ::where('serial', 'like', $key)
                ->orWhere('name', 'like', $key)
                ->orWhere('contact_name', 'like', $key)
                ->orWhere('contact_phone', 'like', $key);
        } else {
            $items = User
                ::where('serial', 'like', $key)
                ->orWhere('name', 'like', $key)
                ->orWhere('contact_name', 'like', $key)
                ->orWhere('contact_phone', 'like', $key)
                ->where('parent_id', '=', \Auth::user()->id);
        }


        return view('company.index')->with([
            'items' => $items->paginate(10)
        ]);
    }
}
