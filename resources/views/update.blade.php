@extends('app')

@section('css')
    <link href="{{ asset('/css/components/form-advanced.almost-flat.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/components/form-select.almost-flat.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/components/autocomplete.almost-flat.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="uk-grid uk-grid-collapse">
        <div class="uk-width-small-2-3 uk-container-center">
            <div class="uk-panel">
                <form class="uk-form uk-container-center uk-form-horizontal" role="form" method="POST" action="{{ url('/update/form') }}">
                    <fieldset data-uk-margin>
                        <legend>配置版本信息</legend>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="uk-form-row">
                            <label  class="uk-form-label">版本号</label>
                            <input type="text" class="form-control" name="version" value="{{$item->version}}" required>
                        </div>
                        <div class="uk-form-row">
                            <label  class="uk-form-label">版本信息</label>
                            <input type="text" class="form-control" name="message" value="{{$item->message}}" required>
                        </div>
                        <div class="uk-form-row">
                            <label  class="uk-form-label">下载地址</label>
                            <input type="text" class="form-control" name="download_url" value="{{$item->download_url}}" required>
                        </div>

                    </fieldset>
                    <fieldset>
                        <div class="uk-form-row">
                            <button type="submit" class="uk-button uk-button-primary">提交</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/components/form-select.min.js') }}"></script>
    <script src="{{ asset('/js/components/autocomplete.min.js') }}"></script>
@endsection