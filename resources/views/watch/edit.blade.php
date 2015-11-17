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
                <form class="uk-form uk-container-center uk-form-horizontal" role="form" method="POST" action="{{ url('watch') }}">
                    <fieldset data-uk-margin>
                        <legend>编辑手表信息</legend>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="uk-form-row">
                            <label  class="uk-form-label">序列号</label>
                            <input type="text" class="form-control" name="pid" value="{{$member->pid}}" required readonly>
                        </div>
                        <div class="uk-form-row">
                            <label  class="uk-form-label">负责人</label>
                            <input type="text" class="form-control" name="uname" value="{{$member->uname}}" required>
                        </div>
                        <div class="uk-form-row">
                            <label  class="uk-form-label">紧急联系人</label>
                            <input type="text" class="form-control" name="emergency_contact" value="{{$contact1?$contact1->name:''}}" required>
                        </div>
                        <div class="uk-form-row">
                            <label  class="uk-form-label">紧急联系人 电话</label>
                            <input type="text" class="form-control" name="emergency_phone" value="{{$contact1?$contact1->phone:''}}" required>
                        </div>
                        <div class="uk-form-row">
                            <label  class="uk-form-label">紧急联系人2</label>
                            <input type="text" class="form-control" name="emergency_contact2" value="{{$contact2?$contact2->name:''}}" required>
                        </div>
                        <div class="uk-form-row">
                            <label  class="uk-form-label">紧急联系人2 电话</label>
                            <input type="text" class="form-control" name="emergency_phone2" value="{{$contact2?$contact2->phone:''}}" required>
                        </div>
                        @if(!$self_as_parent)
                            <div class="uk-form-row">
                                <label  class="uk-form-label">所属企业</label>
                                <select name="fid">
                                    <option value="0">无</option>
                                    @foreach($parents as $parent)
                                        <option value="{{$parent->id}}">{{$parent->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="uk-form-row">
                                <label  class="uk-form-label">所属企业</label>
                                <select name="fid">
                                    @foreach($parents as $parent)
                                        <option value="{{$parent->id}}" selected="selected">{{$parent->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
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