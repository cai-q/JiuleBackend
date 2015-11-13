@extends('app')

@section('css')
    <link href="{{ asset('/css/components/form-advanced.almost-flat.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/components/form-password.almost-flat.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="uk-grid uk-grid-collapse">
        <div class="uk-width-medium-1-3 uk-container-center">
            <div class="uk-panel">
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

                <form class="uk-form uk-container-center" role="form" method="POST" action="{{ url('/auth/register') }}">
                    <fieldset data-uk-margin>
                        <legend>请登录</legend>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="uk-form-row uk-form-icon">
                            <i class="uk-icon-user"></i>
                            <input type="text" class="form-control" name="name" placeholder="请输入用户名" value="{{ old('name') }}">
                        </div>
                        <br>
                        <div class="uk-form-row uk-form-icon">
                            <i class="uk-icon-envelope"></i>
                            <input type="email" class="form-control" name="email" placeholder="请输入登录邮箱" value="{{ old('email') }}">
                        </div>
                        <br>
                        <div class="uk-form-password uk-form-row uk-form-icon">
                            <i class="uk-icon-lock"></i>
                            <input type="text" class="form-control" name="password" placeholder="请输入密码" onfocus="this.type='password'">
                            <a href="" class="uk-form-password-toggle" data-uk-form-password="{lblShow:'显示', lblHide:'隐藏'}" tabindex="-1">显示</a>
                        </div>
                        <br>
                        <div class="uk-form-password uk-form-row uk-form-icon">
                            <i class="uk-icon-lock"></i>
                            <input type="text" class="form-control" name="password_confirmation" placeholder="请再次输入密码" onfocus="this.type='password'">
                            <a href="" class="uk-form-password-toggle" data-uk-form-password="{lblShow:'显示', lblHide:'隐藏'}" tabindex="-1">显示</a>
                        </div>
                        <div class="uk-form-row">
                            <input type="checkbox" name="remember" value=""> 记住此账号
                        </div>

                        <div class="uk-form-row">
                            <button type="submit" class="uk-button uk-button-primary">提交</button>
                            <a class="uk-button uk-button-link" href="{{ url('/password/email') }}">忘记密码</a>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('/js/components/form-password.min.js') }}"></script>
@endsection