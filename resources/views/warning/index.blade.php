@extends('app')

@section('css')
    <link href="{{ asset('/css/components/form-advanced.almost-flat.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/components/form-select.almost-flat.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/components/slidenav.almost-flat.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/components/dotnav.almost-flat.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/components/search.almost-flat.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
@endsection

@section('content')
    <div class="uk-grid uk-grid-collapse">
        <div class="uk-width-small-3-3 uk-container-center">
            <div class="uk-panel">
                @if(Auth::user()->user_type == 1)
                    <a href="{{url('/watch/create')}}" class="uk-button uk-button-primary"><i class="uk-icon uk-icon-plus"></i> 新增手表</a>
                @endif
                <div style="display: inline-block;" id="search">
                    <form class="uk-search" data-uk-search action="{{url('/warning/search')}}">
                        <input class="uk-search-field uk-form-width-large" type="search" name="key" placeholder="在此输入搜索...">
                    </form>
                </div>
                <div class="uk-overflow-container">
                    <table class="uk-table uk-table-hover uk-table-striped">
                        <caption>手表管理</caption>
                        <thead>
                        <tr>
                            <th>用户id</th>
                            <th>spo2</th>
                            <th>heartrate</th>
                            <th>breath</th>
                            <th>skin</th>
                            <th>healthindex</th>
                            <th>ecg_ppt</th>
                            <th>ecg_mrt</th>
                            <th>ecg_p1</th>
                            <th>ecg_b</th>
                            <th>ecg_a</th>
                            <th>ecg_area</th>
                            <th>activity</th>
                            <th>sleep_total_time</th>
                            <th>sleep_effective_time</th>
                            <th>sleep_rover_time</th>
                            <th>latitude</th>
                            <th>longitude</th>
                            <th>gps_type</th>
                            <th>type</th>
                            <th>wear_type</th>
                            <th>time</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php $now = \Carbon\Carbon::now()?>
                        @foreach($items as $item)
                            <tr>
                                <td>{{\App\Member::where('id', $item->userid)->first()->user_id}}</td>
                                <td>{{$item->spo2}}</td>
                                <td>{{$item->heartrate}}</td>
                                <td>{{$item->breath}}</td>
                                <td>{{$item->skin}}</td>
                                <td>{{$item->healthindex}}</td>
                                <td>{{$item->ecg_ppt}}</td>
                                <td>{{$item->ecg_mrt}}</td>
                                <td>{{$item->ecg_p1}}</td>
                                <td>{{$item->ecg_b}}</td>
                                <td>{{$item->ecg_a}}</td>
                                <td>{{$item->ecg_area}}</td>
                                <td>{{$item->activity}}</td>
                                <td>{{$item->sleep_total_time}}</td>
                                <td>{{$item->sleep_effective_time}}</td>
                                <td>{{$item->sleep_rover_time}}</td>
                                <td>{{$item->latitude}}</td>
                                <td>{{$item->longitude}}</td>
                                <td>{{$item->gps_type}}</td>
                                <td>{{$item->type}}</td>
                                <td>{{$item->wear_type}}</td>
                                <td>{{\Carbon\Carbon::createFromTimestamp($item->time, 'Asia/Shanghai')->format('Y-m-d H:i:s')}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $items->render() !!}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/components/form-select.min.js') }}"></script>
    <script src="{{ asset('/js/core/dropdown.min.js') }}"></script>
    <script src="{{ asset('/js/components/lightbox.min.js') }}"></script>
    <script src="{{ asset('/js/components/search.min.js') }}"></script>
@endsection