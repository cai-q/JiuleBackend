<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>久乐-后台</title>

    <link href="{{ asset('/css/uikit.almost-flat.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/components/accordion.almost-flat.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    @yield('css')
</head>
<body>
<nav class="uk-navbar uk-navbar-attached">

    <a href="#api-offcanvas" class="uk-navbar-toggle uk-visible-small" data-uk-offcanvas>
        {{--<i class="uk-icon-bars"></i>--}}
    </a>

    <div class="uk-container uk-container-center">
        <ul class="uk-navbar-nav">
            <li>
                <a style="display: inline-block;" class="navbar-brand" href="{{ url('/home') }}">
                    <img style="height: 100%;" src="/images/logo.png">
                </a>
            </li>
        </ul>

        <div class="uk-navbar-flip">
            <ul class="uk-navbar-nav uk-hidden-small">
                @if (Auth::guest())
                    <li><a href="{{ url('/auth/login') }}">登录</a></li>
                @else
                    <?php $user = Auth::user();?>
                    @if($user->user_type == 0)
                        <li class="uk-parent" data-uk-dropdown="{mode:'click'}">
                            <a href="">
                                久乐管理员
                                <i class="uk-icon-caret-down"></i>
                            </a>

                            <div class="uk-dropdown uk-dropdown-navbar" role="menu">
                                <ul class="uk-nav uk-nav-navbar">
                                    <li class="uk-nav-header">
                                        账号管理
                                    </li>
                                    <li>
                                        <a href="{{ url('/company') }}">
                                            企业管理
                                        </a>
                                    </li>
                                    <li class="uk-nav-divider"></li>
                                    <li class="uk-nav-header">
                                        手表及报警管理
                                    </li>
                                    <li>
                                        <a href="{{ url('/watch') }}">
                                            手表管理
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/warning') }}">
                                            报警管理
                                        </a>
                                    </li>
                                </ul>

                            </div>
                        </li>
                    @endif
                    @if($user->user_type == 1)
                        <li class="uk-parent" data-uk-dropdown="{mode:'click'}">
                            <a href="">
                                企业管理员
                                <i class="uk-icon-caret-down"></i>
                            </a>

                            <div class="uk-dropdown uk-dropdown-navbar" role="menu">
                                <ul class="uk-nav uk-nav-navbar">
                                    <li class="uk-nav-header">
                                        企业信息管理
                                    </li>
                                    <li>
                                        <a href="{{ url('/company/' . $user->id . '/edit') }}">
                                            编辑企业信息
                                        </a>
                                    </li>
                                    <li class="uk-nav-divider"></li>
                                    <li class="uk-nav-header">
                                        子企业管理
                                    </li>
                                    <li>
                                        <a href="{{ url('/company') }}">
                                            子企业列表
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/company/create') }}">
                                            新增子企业
                                        </a>
                                    </li>
                                    <li class="uk-nav-divider"></li>
                                    <li class="uk-nav-header">
                                        手表管理
                                    </li>
                                    <li>
                                        <a href="{{ url('/watch') }}">
                                            手表列表
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/watch/create') }}">
                                            新增绑定
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/watch/activate-list') }}">
                                            批量激活
                                        </a>
                                    </li>
                                    <li class="uk-nav-divider"></li>
                                    <li class="uk-nav-header">
                                        报警查询
                                    </li>
                                    <li>
                                        <a href="{{ url('/warning') }}">
                                            报警列表
                                        </a>
                                    </li>
                                    <li class="uk-nav-divider"></li>
                                </ul>
                            </div>
                        </li>
                    @endif
                    <li class="uk-parent" data-uk-dropdown="{mode:'click'}">
                        <a href="">
                            <i class="uk-icon-user uk-icon-small"></i> {{ Auth::user()->name }}
                            <i class="uk-icon-caret-down"></i>
                        </a>

                        <div class="uk-dropdown uk-dropdown-navbar" role="menu">
                            <ul class="uk-nav uk-nav-navbar">
                                <li><a href="{{ url('/auth/logout') }}">登出</a>
                            </ul>
                        </div>
                    </li>
                    @if(Auth::user() and $locale_id = Auth::user()->locale_id)
                        <li class="uk-parent">
                            <a href="#">
                                <i class="uk-icon-home uk-icon-small"></i>
                                {{\App\Locale::find($locale_id)->city}}
                            </a>
                        </li>
                    @endif
                @endif
            </ul>
        </div>
    </div>
</nav>

<div class="uk-grid">
    @if(!Auth::guest())
        <div class="uk-panel uk-panel-box uk-width-1-6">
            <h3 class="uk-panel-title">菜单</h3>
            <ul class="uk-nav uk-nav-side">
                @if($user->user_type == 0)
                    <li class="uk-parent">
                        <a href="#">
                            账号管理
                        </a>
                        <ul class="uk-nav-sub">
                            <li>
                                <a href="{{ url('/company') }}">
                                    企业管理
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="uk-nav-divider"></li>
                    <li class="uk-parent">
                        <a href="#">
                            手表及报警管理
                        </a>
                        <ul class="uk-nav-sub">
                            <li>
                                <a href="{{ url('/watch') }}">
                                    手表管理
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/warning') }}">
                                    报警管理
                                </a>
                            </li>
                        </ul>
                    </li>
                @elseif($user->user_type == 1)
                    <li class="uk-parent">
                        <a href="#">企业信息管理</a>
                        <ul class="uk-nav-sub">
                            <li>
                                <a href="{{ url('/company/' . $user->id . '/edit') }}">
                                    编辑企业信息
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="uk-nav-divider"></li>
                    <li class="uk-parent">
                        <a href="#">子企业管理</a>
                        <ul class="uk-nav-sub">
                            <li>
                                <a href="{{ url('/company') }}">
                                    子企业列表
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/company/create') }}">
                                    新增子企业
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="uk-nav-divider"></li>
                    <li class="uk-parent">
                        <a href="#">企业手表管理</a>
                        <ul class="uk-nav-sub">
                            <li>
                                <a href="{{ url('/watch') }}">
                                    手表列表
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/watch/create') }}">
                                    新增绑定
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/watch/activate-list') }}">
                                    批量激活
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="uk-nav-divider"></li>
                    <li class="uk-parent">
                        <a href="#">报警管理</a>
                        <ul class="uk-nav-sub">
                            <li>
                                <a href="{{ url('/warning') }}">
                                    报警列表
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    @endif

    <div class="uk-panel uk-width-5-6">
        @if (count($errors) > 0)
            <div class="uk-alert uk-alert-danger">
                <strong>Whoops!</strong> 看起来你输错了什么。<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (\Session::get('success'))
            <div class="uk-alert uk-alert-success">
                <strong>操作成功!</strong>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="{{ asset('/js/uikit.min.js') }}"></script>
<script src="{{ asset('/js/components/accordion.min.js') }}"></script>
@yield('js')
</body>
</html>
