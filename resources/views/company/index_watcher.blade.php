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
                <div style="display: inline-block;" id="search">
                    <form class="uk-search" data-uk-search action="{{url('/company/search')}}">
                        <input class="uk-search-field uk-form-width-large" type="search" name="key" placeholder="在此输入搜索...">
                    </form>
                </div>
                <div class="uk-overflow-container">
                <table class="uk-table uk-table-hover uk-table-striped">
                    <caption>所有监控账号</caption>
                    <thead>
                    <tr>
                        <th>联系人</th>
                        <th>联系电话</th>
                        <th>登陆邮箱</th>
                        <th>企业级别</th>
                        <th>编辑资料</th>
                        <th>删除记录</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($items as $item)
                        <tr>
                            <td>{{$item->contact_name}}</td>
                            <td>{{$item->contact_phone}}</td>
                            <td>{{$item->email}}</td>
                            <td>
                                @if($item->user_type == 0)
                                    <i class="uk-badge" style="background-color: #d43f3a">管理员</i>
                                @elseif($item->user_type == 1)
                                    <i class="uk-badge" style="background-color: #008abf">企业账号</i>
                                @elseif($item->user_type == 2)
                                    <i class="uk-badge" style="background-color: #bf7f6e">监控账号</i>
                                @endif
                            </td>
                            <td>
                                <a class="uk-button uk-form-horizontal" href="/company/{{$item->id}}/edit">编辑</a>
                            </td>
                            <td>
                                <form class="uk-form uk-form-horizontal" action="/company/{{$item->id}}" method="post">
                                    {{ method_field('DELETE') }}
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="uk-button">删除</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
                {!! $items->appends(['key' => isset($key)?$key:'', 'type' => isset($type)?$type:''])->render() !!}
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