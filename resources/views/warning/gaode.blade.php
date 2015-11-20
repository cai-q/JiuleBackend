<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>地图监控</title>
    <link href="{{ asset('/css/uikit.almost-flat.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <script language="javascript"
            src="http://webapi.amap.com/maps?v=1.3&key=d99080f56defbf2c0c886eb595ad7786"></script>
    <script src="__BASE__/js/jquery-1.7.2.min.js" type="text/javascript"></script>
    <style>
        .color {
            background-color: black;
            color: white;
        }

        table, td, tr {
            border: solid 1px;

        }

        .demo_box {
            position: absolute;
            margin-top: 530px;
            height: 230px;
            width: 625px;
            overflow-y: auto;

        }

        hr {
            width: 600px;
            margin: 0px;
        }
    </style>
</head>
<body onload="mapInit();">
<nav class="uk-navbar uk-navbar-attached">
    <a href="#api-offcanvas" class="uk-navbar-toggle uk-visible-small" data-uk-offcanvas>
        {{--<i class="uk-icon-bars"></i>--}}
    </a>
    <div class="uk-container uk-container-center">
        <ul class="uk-navbar-nav">
            <li>
                <a style="display: inline-block;" class="navbar-brand" href="{{ url('/home') }}">
                    <img style="height: 100%;" src="/images/logo.png">
                </a>
            </li>
        </ul>

        <div class="uk-navbar-flip">
            <ul class="uk-navbar-nav uk-hidden-small">
                @if (Auth::guest())
                    <li><a href="{{ url('/auth/login') }}">登录</a></li>
                @else
                    <?php $user = Auth::user();?>
                    @if($user->user_type == 0)
                        <li class="uk-parent" data-uk-dropdown="{mode:'click'}">
                            <a href="">
                                久乐管理员
                                <i class="uk-icon-caret-down"></i>
                            </a>
                            <div class="uk-dropdown uk-dropdown-navbar" role="menu">
                                <ul class="uk-nav uk-nav-navbar">
                                    <li class="uk-nav-header">
                                        账号管理
                                    </li>
                                    <li>
                                        <a href="{{ url('/company') }}">
                                            企业管理
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/member') }}">
                                            用户管理
                                        </a>
                                    </li>
                                    <li class="uk-nav-divider"></li>
                                    <li class="uk-nav-header">
                                        手表及报警管理
                                    </li>
                                    <li>
                                        <a href="{{ url('/watch') }}">
                                            手表管理
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/warning') }}">
                                            报警管理
                                        </a>
                                    </li>
                                </ul>

                            </div>
                        </li>
                    @endif
                    @if($user->user_type == 1)
                        <li class="uk-parent" data-uk-dropdown="{mode:'click'}">
                            <a href="">
                                企业管理员
                                <i class="uk-icon-caret-down"></i>
                            </a>
                            <div class="uk-dropdown uk-dropdown-navbar" role="menu">
                                <ul class="uk-nav uk-nav-navbar">
                                    <li class="uk-nav-header">
                                        企业信息管理
                                    </li>
                                    <li>
                                        <a href="{{ url('/company/' . $user->id . '/edit') }}">
                                            编辑企业信息
                                        </a>
                                    </li>
                                    <li class="uk-nav-divider"></li>
                                    <li class="uk-nav-header">
                                        子企业管理
                                    </li>
                                    <li>
                                        <a href="{{ url('/company') }}">
                                            子企业列表
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/company/create') }}">
                                            新增子企业
                                        </a>
                                    </li>
                                    <li class="uk-nav-divider"></li>
                                    <li class="uk-nav-header">
                                        手表管理
                                    </li>
                                    <li>
                                        <a href="{{ url('/watch') }}">
                                            手表列表
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/watch/create') }}">
                                            新增绑定
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/watch/activate-list') }}">
                                            批量激活
                                        </a>
                                    </li>
                                    <li class="uk-nav-divider"></li>
                                    <li class="uk-nav-header">
                                        报警查询
                                    </li>
                                    <li>
                                        <a href="{{ url('/warning') }}">
                                            报警列表
                                        </a>
                                    </li>
                                    <li class="uk-nav-divider"></li>
                                </ul>
                            </div>
                        </li>
                    @endif
                    <li class="uk-parent" data-uk-dropdown="{mode:'click'}">
                        <a href=""  >
                            <i class="uk-icon-user uk-icon-small"></i>  {{ Auth::user()->name }}
                            <i class="uk-icon-caret-down"></i>
                        </a>
                        <div class="uk-dropdown uk-dropdown-navbar" role="menu">
                            <ul class="uk-nav uk-nav-navbar">
                                <li><a href="{{ url('/auth/logout') }}">登出</a>
                            </ul>
                        </div>
                    </li>
                    @if(Auth::user() and $locale_id = Auth::user()->locale_id)
                        <li class="uk-parent">
                            <a href="#">
                                <i class="uk-icon-home uk-icon-small"></i>
                                {{\App\Locale::find($locale_id)->city}}
                            </a>
                        </li>
                    @endif
                @endif
            </ul>
        </div>
    </div>
</nav>

<div id="iCenter" style="width: 760px; height:540px;margin-right:10px;float:left;"></div>
<div id="uname" style="float:left;margin-right:20px;"></div>
<div style="font-size:15px;float:left;">
    <table>
        <tr>
            <td>姓名</td>
            <td id="uname1"></td>
        </tr>
        <tr>
            <td>电话</td>
            <td id="tel"></td>
        </tr>
        <tr>
            <td>血氧饱和度</td>
            <td id="spo2"></td>
        </tr>
        <tr>
            <td>心率</td>
            <td id="heartrate"></td>
        </tr>
        <tr>
            <td>呼吸</td>
            <td id="breath"></td>
        </tr>
        <tr>
            <td>皮肤导电性</td>
            <td id="skin"></td>
        </tr>
        <tr>
            <td>报警类型</td>
            <td id="type"></td>
        </tr>
        <tr>
            <td>定位类型</td>
            <td id="gps_type"></td>
        </tr>
        <tr>
            <td>是否佩戴</td>
            <td id="wear_type"></td>
        </tr>
        <tr>
            <td>报警时间</td>
            <td id="warntime"></td>
        </tr>
        <tr>
            <td colspan="2" align="center">紧急联系人1</td>
        </tr>
        <tr>
            <td>姓名</td>
            <td id="name1"></td>
        </tr>
        <tr>
            <td>电话</td>
            <td id="phone1"></td>
        </tr>
        <tr>
            <td>关系</td>
            <td id="relationship1"></td>
        </tr>
        <tr>
            <td colspan="2" align="center">紧急联系人2</td>
        </tr>
        <tr>
            <td>姓名</td>
            <td id="name2"></td>
        </tr>
        <tr>
            <td>电话</td>
            <td id="phone2"></td>
        </tr>
        <tr>
            <td>关系</td>
            <td id="relationship2"></td>
        </tr>
    </table>
</div>
<div class="demo_box">
    <div id="r_title"><b>查询结果:</b></div>
    <div id="result"></div>
</div>

<div id="div2"></div>
<div id="div1"></div>

<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="{{ asset('/js/uikit.min.js') }}"></script>
</body>
<script language="javascript">
    var ajaxUrl = '{$ajaxurl}';
    var ajaxUrl2 = '{$ajaxurl2}';
    var ajaxUrl3 = '{$ajaxurl3}';
    var ajaxUrl4 = '{$ajaxurl4}';
    var ajaxUrl5 = '{$ajaxurl5}';
    var mapObj;
    var unamestr = "";
    var data = "";
    function refreshDate() {
        var unamestr = "";
        $.post(ajaxUrl, {}, function (data) {
            if (data != null) {
                mapObj.clearMap();
                for (var i = 0; i < data.length; i++) {
                    var rsname = data[i]['uname'];
                    if (data[i]['type_str'] == '问题解决') {
                        var color = '';
                    } else if (data[i]['type_str'] == '处理中') {
                        var color = 'color:#ff0000';
                    } else {
                        var color = 'color:#ff0000';
                        play_click("__BASE__/bak/warn.mp3");
                    }

                    unamestr += "<div id='a" + data[i]['userid'] + "' style='cursor:pointer;" + color + "' onclick='geocoder(" + data[i]['longitude'] + "," + data[i]['latitude'] + "," + data[i]['wid'] + ",a" + data[i]['userid'] + ")'>" + rsname + "</div>";
                    marker(data[i]['longitude'], data[i]['latitude'], rsname, data[i]['icon']);
                }
                document.getElementById("uname").innerHTML = unamestr;
            } else {
                mapObj.clearMap();
                document.getElementById("uname").innerHTML = '没有报警';
            }
        }, "json")
    }


    function initDate() {
        $.post(ajaxUrl, {}, function (data) {
            if (data != null) {
                for (var i = 0; i < data.length; i++) {
                    var rsname = data[i]['uname'];
                    if (data[i]['type_str'] != '问题解决') {
                        var color = 'color:#ff0000';

                    } else {
                        var color = '';
                    }
                    unamestr += "<div id='a" + data[i]['userid'] + "' style='cursor:pointer;" + color + "' onclick='geocoder(" + data[i]['longitude'] + "," + data[i]['latitude'] + "," + data[i]['wid'] + ",a" + data[i]['userid'] + ")'>" + rsname + "</div>";
                    marker(data[i]['longitude'], data[i]['latitude'], rsname, data[i]['icon']);
                }

                document.getElementById("uname1").innerHTML = '<a href="{:U(\'orfind/neardata\')}?id=' + data[0]['wid'] + '" target="_blank">' + data[0]['uname'] + '</a>';
                document.getElementById("tel").innerHTML = data[0]['tel'];
                document.getElementById("spo2").innerHTML = data[0]['spo2'];
                document.getElementById("heartrate").innerHTML = data[0]['heartrate'];
                document.getElementById("skin").innerHTML = data[0]['skin'];
                document.getElementById("type").innerHTML = data[0]['type_str'];
                document.getElementById("gps_type").innerHTML = data[0]['gps_type'];
                document.getElementById("wear_type").innerHTML = data[0]['wear_type'];
                document.getElementById("warntime").innerHTML = data[0]['warntime'];
                document.getElementById("breath").innerHTML = data[0]['breath'];
                document.getElementById("name1").innerHTML = data[0]['relationship'][0]['name'];
                document.getElementById("phone1").innerHTML = data[0]['relationship'][0]['phone'];
                document.getElementById("relationship1").innerHTML = data[0]['relationship'][0]['relationship'];
                document.getElementById("name2").innerHTML = data[0]['relationship'][1]['name'];
                document.getElementById("phone2").innerHTML = data[0]['relationship'][1]['phone'];
                document.getElementById("relationship2").innerHTML = data[0]['relationship'][1]['relationship'];
                document.getElementById("uname").innerHTML = unamestr;
            } else {
                document.getElementById("uname").innerHTML = '没有报警';
            }
        }, "json")
    }


    function mapInit() {

        mapObj = new AMap.Map("iCenter", {
            view: new AMap.View2D({
                center: new AMap.LngLat(105.56341773223333, 34.80699943333),//地图中心点
                zoom: 5 //地图显示的缩放级别
            })
        });
        mapObj.setFitView();
        initDate();
        timeid = window.setInterval(refreshDate, 15000);
    }
    //已知点坐标

    function geocoder(longitude, latitude, wid, id) {
        var lnglatXY = new AMap.LngLat(longitude, latitude);
        var MGeocoder;
        //加载地理编码插件
        mapObj.plugin(["AMap.Geocoder"], function () {
            MGeocoder = new AMap.Geocoder({
                radius: 1000,
                extensions: "all"
            });
            //返回地理编码结果
            AMap.event.addListener(MGeocoder, "complete", geocoder_CallBack);
            //逆地理编码
            MGeocoder.getAddress(lnglatXY);
        });

        mapObj.setZoomAndCenter(16, lnglatXY);
        $.post(ajaxUrl2, {mid: wid}, function (data) {
            document.getElementById("uname1").innerHTML = '<a href="{:U(\'orfind/neardata\')}?id=' + data[0]['wid'] + '" target="_blank">' + data[0]['uname'] + '</a>';
            document.getElementById("tel").innerHTML = data[0]['tel'];
            document.getElementById("spo2").innerHTML = data[0]['spo2'];
            document.getElementById("heartrate").innerHTML = data[0]['heartrate'];
            document.getElementById("skin").innerHTML = data[0]['skin'];
            document.getElementById("type").innerHTML = data[0]['type_str'];
            document.getElementById("gps_type").innerHTML = data[0]['gps_type'];
            document.getElementById("wear_type").innerHTML = data[0]['wear_type'];
            document.getElementById("warntime").innerHTML = data[0]['warntime'];
            document.getElementById("breath").innerHTML = data[0]['breath'];
            document.getElementById("name1").innerHTML = data[0]['relationship'][0]['name'];
            document.getElementById("phone1").innerHTML = data[0]['relationship'][0]['phone'];
            document.getElementById("relationship1").innerHTML = data[0]['relationship'][0]['relationship'];
            document.getElementById("name2").innerHTML = data[0]['relationship'][1]['name'];
            document.getElementById("phone2").innerHTML = data[0]['relationship'][1]['phone'];
            document.getElementById("relationship2").innerHTML = data[0]['relationship'][1]['relationship'];

        }, "json")

        $("div").removeClass('color');
        $(id).addClass('color');

    }


    //加点
    function marker(longitude, latitude, name, icon) {
        var lnglatXY = new AMap.LngLat(longitude, latitude);
        var marker = new AMap.Marker({
            icon: '__BASE__/images/' + icon + '.png',
            title: name,
            position: lnglatXY,
            offset: new AMap.Pixel(-5, -30)
        });
        marker.setMap(mapObj);
    }


    //回调函数
    function geocoder_CallBack(data) {
        var resultStr = "";
        var roadinfo = "";
        var poiinfo = "";
        var address;
        //返回地址描述
        address = data.regeocode.formattedAddress;
        //返回周边道路信息
        roadinfo += "<table style='width:600px;font-size:12px;'>";
        for (var i = 0; i < data.regeocode.roads.length; i++) {
            var color = (i % 2 === 0 ? '#fff' : '#eee');
            roadinfo += "<tr style='background-color:" + color + "; margin:0; padding:0;'><td>道路：" + data.regeocode.roads[i].name + "</td><td>方向：" + data.regeocode.roads[i].direction + "</td><td>距离：" + data.regeocode.roads[i].distance + "米</td></tr>";
        }
        roadinfo += "</table>"
        //返回周边兴趣点信息
        poiinfo += "<table style='width:600px;font-size:12px;'>";
        for (var j = 0; j < data.regeocode.pois.length; j++) {
            var color = j % 2 === 0 ? '#fff' : '#eee';
            poiinfo += "<tr style='background-color:" + color + "; margin:0; padding:0;'><td>兴趣点：" + data.regeocode.pois[j].name + "</td><td>类型：" + data.regeocode.pois[j].type + "</td><td>距离：" + data.regeocode.pois[j].distance + "米</td></tr>";
        }
        poiinfo += "</table>";
        //返回结果拼接输出
        resultStr = "<div style=\"font-size:12px;padding:0px 0 4px 2px; border-bottom:1px solid #C1FFC1;\">" + "<b>地址</b>：" + address + "<hr/><b>周边道路信息</b>：<br/>" + roadinfo + "<hr/><b>周边兴趣点信息</b>：<br/>" + poiinfo + "</div>";
        document.getElementById("result").innerHTML = resultStr;
    }

    function play_click(url) {
        var div = document.getElementById('div1');
        div.innerHTML = '<embed src="' + url + '" loop="0" autostart="true" hidden="true"></embed>';
        var emb = document.getElementsByTagName('EMBED')[0];
        if (emb) {
            /* 这里可以写成一个判断 wav 文件是否已加载完毕，以下采用setTimeout模拟一下 */
            div = document.getElementById('div2');
            div.innerHTML = 'loading: ' + emb.src;
            setTimeout(function () {
                div.innerHTML = '';
            }, 1000);
        }
    }

</script>

</html>



	