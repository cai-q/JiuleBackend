@extends('app')

@section('css')
    <link href="{{ asset('/css/components/form-advanced.almost-flat.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/components/form-select.almost-flat.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="uk-grid uk-grid-collapse">
        <div class="uk-width-small-1-3 uk-container-center">
            <div class="uk-panel">
                <form class="uk-form uk-container-center uk-form-horizontal" role="form" method="POST" action="{{ url('admin/walkers/'. $item->id) }}">
                    <input name="_method" type="hidden" value="PUT">
                    <fieldset data-uk-margin>
                        <legend>基本信息</legend>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="uk-form-row">
                            <label  class="uk-form-label">姓名</label>
                            <input type="text" class="form-control" name="name" value="{{$item->name}}" required>
                        </div>
                        <div class="uk-form-row">
                            <label  class="uk-form-label">电话号码</label>
                            <input type="text" class="form-control" name="phone" value="{{$item->phone}}" required readonly>
                        </div>
                        <div class="uk-form-row">
                            <label  class="uk-form-label">身份证号</label>
                            <input type="text" class="form-control" name="identify_card_number" value="{{$item->identify_card_number}}" required readonly>
                        </div>
                    </fieldset>
                    <fieldset data-uk-margin>
                        <legend>车辆信息</legend>
                        <div class="uk-form-row">
                            <label class="uk-form-label">车牌号</label>
                            <input type="text" class="form-control" name="car_num" required value="{{$item->car_num}}">
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label">车型</label>
                            <select name="type">
                                <option value="1"<?php echo ($item->type == 1)?' selected':'' ?>>微面斑马</option>
                                <option value="2"<?php echo ($item->type == 2)?' selected':'' ?>>中面斑马</option>
                                <option value="3"<?php echo ($item->type == 3)?' selected':'' ?>>货车斑马</option>
                                <option value="4"<?php echo ($item->type == 4)?' selected':'' ?>>冷链斑马</option>
                                <option value="5"<?php echo ($item->type == 5)?' selected':'' ?>>两轮斑马</option>
                            </select>
                        </div>

                    </fieldset>
                    <fieldset>
                        <legend>附加信息</legend>
                        <div class="uk-form-row">
                            <label class="uk-form-label">车型描述</label>
                            <input type="text" class="form-control" name="car_type_description" value="{{$item->car_type_description}}">
                        </div>
                        <br>
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
@endsection