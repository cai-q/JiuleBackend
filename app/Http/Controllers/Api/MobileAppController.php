<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MobileAppController extends Controller
{
    public function postLogin(\Request $request)
    {
        //TODO app login
    }

    public function postMessage(\Request $request)
    {
        //TODO download new message
    }

    public function postUpdate(\Request $request)
    {
        //TODO get the download link
    }

    public function postActivate(\Request $request)
    {
        //TODO activate a watch
    }

    public function postUserIndex(\Request $request)
    {
        //TODO get the index information
    }
}
