@extends('app')

@section('css')
<link href="{{ asset('/css/components/form-advanced.almost-flat.min.css') }}" rel="stylesheet">
<link href="{{ asset('/css/components/form-select.almost-flat.min.css') }}" rel="stylesheet">
<link href="{{ asset('/css/components/form-file.almost-flat.min.css') }}" rel="stylesheet">
<link href="{{ asset('/css/components/autocomplete.almost-flat.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="uk-grid uk-grid-collapse">
    <div class="uk-width-small-2-3 uk-container-center">
        <div class="uk-panel">
            <form class="uk-form uk-container-center uk-form-horizontal" role="form" method="POST" action="{{ url('watch/multiple-create') }}" enctype="multipart/form-data" >
                <fieldset data-uk-margin>
                    <legend>批量添加手表</legend>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <input type="file" name="watch" accept="application/xslt+xml">
                        <button type="submit" class="uk-button uk-button-primary">提交</button>
                </fieldset>

            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('/js/components/form-select.min.js') }}"></script>
<script src="{{ asset('/js/components/autocomplete.min.js') }}"></script>
<script src="{{ asset('/js/components/upload.min.js') }}"></script>
@endsection