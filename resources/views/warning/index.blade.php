@extends('app')

@section('css')
    <link href="{{ asset('/css/components/form-advanced.almost-flat.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/components/form-select.almost-flat.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/components/slidenav.almost-flat.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/components/dotnav.almost-flat.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/components/search.almost-flat.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/components/datepicker.almost-flat.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
@endsection

@section('content')
    <div class="uk-grid uk-grid-collapse">
        <div class="uk-width-small-3-3 uk-container-center">
            <div class="uk-panel">
                <div style="display: inline-block;" id="search">
                    <form  data-uk-search action="{{url('/warning/search')}}">
                        <select id="se1" name="select">
                            <option value="time">时间段</option>
                            <option value="userid">用户名</option>
                            <option value="pid">序列号</option>
                        </select>
                        <span id="op2" class="uk-hidden">
                            <input class="uk-search-field uk-form-width-large" type="search" name="key" placeholder="在此输入搜索...">
                        </span>
                        <span id="op1">
                            <input class="uk-form-small" name="start" type="datetime" data-uk-datepicker="{format:'YYYY-MM-DD'}" placeholder="开始日期" readonly>
                            -
                            <input class="uk-form-small" name="end" type="datetime" data-uk-datepicker="{format:'YYYY-MM-DD'}" placeholder="结束日期" readonly>
                        </span>
                        <button class="uk-button uk-button-small" type="submit">搜索</button>
                    </form>
                </div>
                <div class="uk-overflow-container">
                    <table class="uk-table uk-table-hover uk-table-striped">
                        <caption>手表管理</caption>
                        <thead>
                        <tr>
                            <th>序列号</th>
                            <th>负责人</th>
                            <th>电话</th>
                            <th>报警类型</th>
                            <th>时间</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php $now = \Carbon\Carbon::now()?>
                        @foreach($items as $item)
                            <tr>
                                <td>{{$item->pid}}</td>
                                <td>{{$item->uname}}</td>
                                <td>{{$item->phone}}</td>
                                <td>
                                    <div class="uk-badge uk-badge-warning">
                                        @if($item->type == 1)
                                            紧急呼叫
                                        @elseif($item->type == 2)
                                            预警
                                        @elseif($item->type == 3)
                                            报警
                                        @elseif($item->type == 4)
                                            跌倒
                                        @elseif($item->type == 5)
                                            健康提醒
                                        @endif
                                    </div>
                                </td>
                                <td>{{Carbon\Carbon::createFromTimestamp($item->time, 'Asia/Shanghai')->toDateTimeString()}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $items->appends(['key' => isset($key)?$key:'', 'start' => isset($start)?$start:'', 'end' => isset($end)?$end:'', 'select' => isset($select)?$select:''])->render() !!}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/components/form-select.min.js') }}"></script>
    <script src="{{ asset('/js/core/dropdown.min.js') }}"></script>
    <script src="{{ asset('/js/components/lightbox.min.js') }}"></script>
    <script src="{{ asset('/js/components/search.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("#se1").change(function () {
                a = $("#se1").val();
                if (a == 'time') {
                    $("#op2").addClass('uk-hidden');
                    $("#op1").removeClass('uk-hidden');
                } else {

                    $("#op1").addClass('uk-hidden');
                    $("#op2").removeClass('uk-hidden');
                }
            });
        });
    </script>
    <script src="{{ asset('/js/components/datepicker.min.js') }}"></script>
@endsection