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
                <a href="{{url('/company/create')}}" class="uk-button uk-button-primary"><i class="uk-icon uk-icon-plus"></i> 新增企业账号</a>
                <table class="uk-table uk-table-hover uk-table-striped">
                    <caption>所有企业账号</caption>
                    <thead>
                    <tr>
                        <th>企业编号</th>
                        <th>企业名称</th>
                        <th>登陆邮箱</th>
                        <th>企业级别</th>
                        <th>父级企业编号（如存在）</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($items as $item)
                        <tr>
                            <td>{{$item->serial}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->emali}}</td>
                            <td>{{$item->user_type}}</td>
                            <td>{{$item->parent_id}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
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