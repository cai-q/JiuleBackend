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
                <form class="uk-form uk-container-center uk-form-horizontal" role="form" method="POST" action="/company/{{$item->id}}">
                    <fieldset data-uk-margin>
                        <legend>修改资料</legend>
                        {{ method_field('PUT') }}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="uk-form-row">
                            <label  class="uk-form-label">企业编号</label>
                            <input type="text" class="form-control" name="serial" value="{{$item->serial}}" required disabled>
                        </div>
                        <div class="uk-form-row">
                            <label  class="uk-form-label">登陆邮箱</label>
                            <input type="email" class="form-control" name="email" value="{{$item->email}}" required disabled>
                        </div>
                        <div class="uk-form-row">
                            <label  class="uk-form-label">企业名称</label>
                            <input type="text" class="form-control" name="name" value="{{$item->name}}" required disabled>
                        </div>
                        <div class="uk-form-row">
                            <label  class="uk-form-label">联系人</label>
                            <input type="text" class="form-control" name="contact_name" value="{{$item->contact_name}}" required>
                        </div>
                        <div class="uk-form-row">
                            <label  class="uk-form-label">联系电话</label>
                            <input type="text" class="form-control" name="contact_phone" value="{{$item->contact_phone}}" required>
                        </div>
                        <div class="uk-form-row">
                            <label  class="uk-form-label">父级企业</label>
                            <input type="text" class="form-control" name="contact_phone" value="{{$item->parent_id != 1 ? \App\User::find($item->parent_id)->serial : '无'}}" required disabled>
                        </div>
                        <div class="uk-form-row">
                            <label  class="uk-form-label">企业地址</label>
                            <input type="text" class="form-control" name="address" value="{{$item->address}}">
                        </div>
                        <div class="uk-form-row">
                            <label  class="uk-form-label">营业执照</label>
                            <input type="text" class="form-control" name="certificate" value="{{$item->certificate}}">
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