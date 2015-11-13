@extends('app')

@section('css')
    <link href="{{ asset('/css/components/form-advanced.almost-flat.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/components/form-password.almost-flat.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="uk-grid uk-grid-collapse">
        <div class="uk-width-small-1-3 uk-container-center">
            <div class="uk-panel">
                @if (session('status'))
                    <div class="uk-alert uk-alert-success">
                        {{ session('status') }}
                    </div>
                @endif

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

                <form class="uk-form uk-container-center" role="form" method="POST" action="{{ url('/password/email') }}">
                    <fieldset data-uk-margin>
                        <legend>重置密码</legend>
                        <input type="hidden" class="uk-width-1-1" name="_token" value="{{ csrf_token() }}">
                        <div class="uk-form-row">
                            <input type="email" class="form-control" name="email" placeholder="请输入登录邮箱" value="{{ old('email') }}">
                        </div>
                        <br>
                        <div class="uk-form-row">
                            <button type="submit" class="uk-button uk-button-primary">发送重置链接</button>
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