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
                    <a href="{{url('/watch/create')}}" class="uk-button uk-button-primary"><i
                                class="uk-icon uk-icon-plus"></i>新增手表</a>
                    <a href="{{url('/watch/multiple-create')}}" class="uk-button uk-button-primary"><i
                                class="uk-icon uk-icon-plus"></i>批量导入</a>
                @endif
                <div style="display: inline-block;" id="search">
                    <form class="uk-search" data-uk-search action="{{url('/watch/search')}}">
                        <input class="uk-search-field uk-form-width-large" type="search" name="key"
                               placeholder="在此输入搜索...">
                    </form>
                </div>
                <div class="uk-overflow-container">
                    <table class="uk-table uk-table-hover uk-table-striped">
                        <caption>手表管理</caption>
                        <thead>
                        <tr>
                            <th>序列号</th>
                            <th>登陆名</th>
                            <th>是否出库</th>
                            <th>是否激活</th>
                            <th>是否活跃</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php $now = \Carbon\Carbon::now()?>
                        @foreach($items as $item)
                            <tr>
                                <td>
                                    <i class="uk-badge uk-badge-warning">
                                        {{$item->pid}}
                                    </i>
                                </td>
                                <td>{{$item->userid}}</td>
                                <td>
                                    @if(($a = DB::connection('mysql_old')->table('product_ext')->where('pid', ''.$item->pid)->first()) != null)
                                        @if($a->saled == 1)
                                            <i class="uk-badge uk-badge-success">
                                                已售出
                                            </i>
                                        @else
                                            <i class="uk-badge uk-badge-danger">
                                                未售出
                                            </i>
                                        @endif
                                    @else
                                        <i class="uk-badge uk-badge-danger">
                                            未查询到
                                        </i>
                                    @endif
                                </td>
                                <td>
                                    @if($item->status == 0)
                                        <i class="uk-badge uk-badge-success">
                                            已激活
                                        </i>
                                    @else
                                        <i class="uk-badge uk-badge-error">
                                            未激活
                                        </i>
                                    @endif
                                </td>
                                <td>
                                    @if(\Carbon\Carbon::createFromTimestamp($item->logintime, 'Asia/Shanghai')->diffInDays($now) <= ($item->fid?\App\User::find($item->fid)->expire_days:7))
                                        <i class="uk-badge uk-badge-success">
                                            活跃
                                        </i>
                                    @else
                                        <i class="uk-badge uk-badge-danger">
                                            不活跃
                                        </i>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: inline-block; position: relative;"
                                         data-uk-dropdown="{mode:'click'}">
                                        <button class="uk-button">
                                            操作
                                            <i class="uk-icon-caret-down"></i>
                                        </button>
                                        <div class="uk-dropdown">
                                            <ul class="uk-nav uk-nav-dropdown">
                                                @if($item->status == 0)
                                                    <li><a class="uk-text-"
                                                           href="{{url('watch/'. $item->id . '/edit')}}">编辑资料</a></li>
                                                @else
                                                    <li><a class="uk-text-"
                                                           href="{{url('watch/activate?pid='.$item->id)}}">一键激活</a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </td>
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