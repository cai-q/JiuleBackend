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
        return view('company.index')->with(
            [
                'items' => User::where('id', '>', 0)->paginate(10)
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.create')->with(
            [
                'parents' => User::where('user_type', 1)
            ]
        );
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
            'user_type'
        ];

        $user = new User();
        foreach ($list as $enum) {
            if ($request->has($enum)) {
                $user->$enum = $request->input($enum);
            }
        }

        $user->password = bcrypt($request->input('password'));
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
}
