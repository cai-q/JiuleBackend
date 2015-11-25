@extends('app')

@section('css')
    <link href="{{ asset('/css/components/form-advanced.almost-flat.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/components/form-select.almost-flat.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/components/slidenav.almost-flat.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/components/dotnav.almost-flat.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/components/search.almost-flat.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <style>
        .uk-description-list-horizontal > dt {
            width: 80px;
        }
        .uk-description-list-horizontal > dd {
            margin-left: 0;
        }
        .uk-grid {
            margin: 0%;
        }
        #grad {
            height: 100px;
            background: -webkit-linear-gradient(left, #36ba55, #098dff); /* Safari 5.1 - 6.0 */
            background: -o-linear-gradient(left, #36ba55, #098dff); /* Opera 11.1 - 12.0 */
            background: -moz-linear-gradient(left, #36ba55, #098dff); /* Firefox 3.6 - 15 */
            background: linear-gradient(left, #36ba55, #098dff); /* 标准的语法（必须放在最后） */
        }
    </style>
@endsection

@section('content')
    <div class="uk-grid uk-grid-small" style="margin: 0;">
        <div class="uk-panel uk-width-2-5" style="height: 700px; display: inline-block; background-color: antiquewhite;">

        </div>
        <div class="uk-panel uk-width-3-5 uk-grid uk-grid-small" style="display: inline-block">
            <div class="uk-width-1-6">
                <ul class="uk-tab uk-tab-left" data-uk-tab="">
                    <li><a href="">小明</a></li>
                    <li><a href="">小明</a></li>
                    <li><a href="">小明</a></li>
                    <li><a href="">小明</a></li>
                    <li><a href="">小明ddddddd</a></li>
                    <li><a href="">小明</a></li>
                    <li><a href="">小明</a></li>
                    <li><a href="">小明</a></li>
                    <li><a href="">小明</a></li>
                    <li><a href="">小明</a></li>
                    <li><a href="">小明</a></li>
                    <li><a href="">小明</a></li>
                    <li><a href="">小明</a></li>
                    <li><a href="">小明</a></li>
                    <li><a href="">小明</a></li>
                    <li><a href="">小明</a></li>
                </ul>
            </div>
            <div class="uk-width-5-6">
                <div id="grad">
                </div>

                <div class="uk-article" style="text-align: center; position: relative">
                    <img style="display: inline-block;background-color: yellowgreen; border-radius: 80px; border-color: white; border-style: solid; border-width: 3px; height: 80px; width: 80px; margin: -40px auto 0 auto;">
                    <div class="uk-panel uk-panel-box">
                        <h1 class="uk-article-title">详细信息</h1>
                        <div class="uk-grid uk-grid-collapse" style="padding-left: 0">
                            <div class="uk-width-1-2">
                                <dl class="uk-description-list-horizontal">
                                    <dt>性别</dt>
                                    <dd>男</dd>
                                </dl>

                                <dl class="uk-description-list-horizontal">
                                    <dt>电话</dt>
                                    <dd>18888888888</dd>
                                </dl>
                                <dl class="uk-description-list-horizontal">
                                    <dt>血氧饱和度</dt>
                                    <dd>18888888888</dd>
                                </dl>
                                <dl class="uk-description-list-horizontal">
                                    <dt>心率</dt>
                                    <dd>18888888888</dd>
                                </dl>
                                <dl class="uk-description-list-horizontal">
                                    <dt>呼吸</dt>
                                    <dd>18888888888</dd>
                                </dl>
                                <dl class="uk-description-list-horizontal">
                                    <dt>报警类型</dt>
                                    <dd>18888888888</dd>
                                </dl>
                                <dl class="uk-description-list-horizontal">
                                    <dt>定位类型</dt>
                                    <dd>18888888888</dd>
                                </dl>
                                <dl class="uk-description-list-horizontal">
                                    <dt>是否佩戴</dt>
                                    <dd>18888888888</dd>
                                </dl>
                                <dl class="uk-description-list-horizontal">
                                    <dt>报警事件</dt>
                                    <dd>18888888888</dd>
                                </dl>
                                <dl class="uk-description-list-horizontal">
                                    <dt>皮肤导电性</dt>
                                    <dd>18888888888</dd>
                                </dl>
                            </div>
                            <div class="uk-width-1-2">
                                <dl class="uk-description-list-horizontal">
                                    <dt>紧急联系人1</dt>
                                    <dd></dd>
                                </dl>
                                <dl class="uk-description-list-horizontal">
                                    <dt>姓名</dt>
                                    <dd>小明</dd>
                                </dl>
                                <dl class="uk-description-list-horizontal">
                                    <dt>电话</dt>
                                    <dd>188888888</dd>
                                </dl>
                                <dl class="uk-description-list-horizontal">
                                    <dt></dt>
                                    <dd></dd>
                                </dl>
                                <dl class="uk-description-list-horizontal">
                                    <dt>紧急联系人2</dt>
                                    <dd></dd>
                                </dl>
                                <dl class="uk-description-list-horizontal">
                                    <dt>姓名</dt>
                                    <dd>小明</dd>
                                </dl>
                                <dl class="uk-description-list-horizontal">
                                    <dt>电话</dt>
                                    <dd>188888888</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="uk-panel uk-panel-box uk-margin-top" style="text-align: left">
                        <dl class="uk-description-list-horizontal">
                            <dt>地址信息:</dt>
                            <dd>123</dd>
                        </dl>
                        <dl class="uk-description-list-horizontal">
                            <dt>周边信息:</dt>
                            <dd>123</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="uk-panel uk-panel-box">
        <div class="uk-grid">
            <div class="uk-width-1-5">
                <dl class="uk-description-list-horizontal">
                    <dt>报警时间:</dt>
                    <dd>123</dd>
                </dl>
            </div>
            <div class="uk-width-1-5">
                <dl class="uk-description-list-horizontal">
                    <dt>报警类型:</dt>
                    <dd>123</dd>
                </dl>
            </div>
            <div class="uk-width-1-5">
                <dl class="uk-description-list-horizontal">
                    <dt>处理情况:</dt>
                    <dd></dd>
                </dl>
            </div>
            <div class="uk-width-1-5">
                <dl class="uk-description-list-horizontal">
                    <dt>处理类型:</dt>
                    <dd></dd>
                </dl>
            </div>
            <div class="uk-width-1-5">
                <dl class="uk-description-list-horizontal">
                    <dt>处理人:</dt>
                    <dd></dd>
                </dl>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/components/form-select.min.js') }}"></script>
    <script src="{{ asset('/js/core/dropdown.min.js') }}"></script>
    <script src="{{ asset('/js/core/tab.min.js') }}"></script>
    <script src="{{ asset('/js/components/lightbox.min.js') }}"></script>
    <script src="{{ asset('/js/components/search.min.js') }}"></script>
@endsection