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
            width: 90px;
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
		.color{
			background-color:black;
			color:white;
		}
    </style>
@endsection

@section('content')
    <div class="uk-grid uk-grid-small" style="margin: 0;">
        <div id="iCenter" class="uk-panel uk-width-2-5" style="height: 700px; display: inline-block; background-color: antiquewhite;">

        </div>
        <div class="uk-panel uk-width-3-5 uk-grid uk-grid-small" style="display: inline-block">
            <div class="uk-width-1-6">
                <ul id="uname" class="uk-tab uk-tab-left" data-uk-tab="">
                    
                </ul>
            </div>
            <div class="uk-width-5-6">
               <!--<div id="grad">
                </div> -->

                <div class="uk-article" style="text-align: center; position: relative">
                    <!--<img style="display: inline-block;background-color: yellowgreen; border-radius: 80px; border-color: white; border-style: solid; border-width: 3px; height: 80px; width: 80px; margin: -40px auto 0 auto;">-->
                    <div class="uk-panel uk-panel-box">
                        <h1 class="uk-article-title" id="uname1"></h1>
                        <div class="uk-grid uk-grid-collapse" style="padding-left: 0">
                            <div class="uk-width-1-2">
                                <dl class="uk-description-list-horizontal">
                                    <dt>序列号</dt>
                                    <dd id="ccid"></dd>
                                </dl> 
								<dl class="uk-description-list-horizontal">
                                    <dt>性别</dt>
                                    <dd id="sex"></dd>
                                </dl>
                                <dl class="uk-description-list-horizontal">
                                    <dt >电话</dt>
                                    <dd id="tel"></dd>
                                </dl>
                                <dl class="uk-description-list-horizontal">
                                    <dt>血氧饱和度</dt>
                                    <dd id="spo2"></dd>
                                </dl>
                                <dl class="uk-description-list-horizontal">
                                    <dt>心率</dt>
                                    <dd id="heartrate"></dd>
                                </dl>
                                <dl class="uk-description-list-horizontal">
                                    <dt>呼吸</dt>
                                    <dd id="breath"></dd>
                                </dl>
								<dl class="uk-description-list-horizontal">
                                    <dt>皮肤导电性</dt>
                                    <dd id="skin"></dd>
                                </dl>
                               
                                <dl class="uk-description-list-horizontal">
                                    <dt>是否佩戴</dt>
                                    <dd id="wear_type"></dd>
                                </dl>
                               
                            </div>
                            <div class="uk-width-1-2">
                                <dl class="uk-description-list-horizontal">
                                    <dt>紧急联系人1</dt>
                                    <dd id="name1"></dd>
                                </dl>
                                <dl class="uk-description-list-horizontal">
                                    <dt>电话</dt>
                                    <dd id="phone1"></dd>
                                </dl>
                               <!-- <dl class="uk-description-list-horizontal">
                                    <dt></dt>
                                    <dd></dd>
                                </dl>-->
                                <dl class="uk-description-list-horizontal">
                                    <dt>紧急联系人2</dt>
                                    <dd id="name2"></dd>
                                </dl>
                                <dl class="uk-description-list-horizontal">
                                    <dt>电话</dt>
                                    <dd id="phone2"></dd>
                                </dl>
								 <dl class="uk-description-list-horizontal">
                                    <dt>报警类型</dt>
                                    <dd id="type_str"></dd>
                                </dl>
                                <dl class="uk-description-list-horizontal">
                                    <dt>定位类型</dt>
                                    <dd id="gps_type"></dd>
                                </dl>
								 <dl class="uk-description-list-horizontal">
                                    <dt>处理情况</dt>
                                    <dd id="c_type"></dd>
                                </dl> 
								<dl class="uk-description-list-horizontal">
                                    <dt>报警时间</dt>
                                    <dd id="time"></dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="uk-panel uk-panel-box uk-margin-top" style="text-align: left">
                        <dl class="uk-description-list-horizontal">
                            <dt>地址信息:</dt>
                            <dd id="result"></dd>
                        </dl>
                    </div>
                </div>
            </div>
			<div class="uk-width-5-6" style="margin-left:16.666%">
			<table border="0" cellspacing="0" cellpadding="0"  style="margin-top:5px;width:100%">
						  <tr align="center" style="background:#D7D7D7;line-height:30px;">
							<th id="swarn" align="center" style="border:1px solid #cccccc;text-align:center">处理情况</th>
						  </tr>
						  
                          <tr align="center" id="solve_do" style="" >
							<td><textarea id="solve" style="height:200px;width:100%;margin-top:5px;" class="disable"></textarea>
							<input id="proce" type="button" value="处理" style="margin:4px;margin-right:10%;width:100px" class="disable" onclick="solveWarn()"/>
							<input id="cancel" type="button" value="完成" style="margin:4px;margin-left:10%;width:100px" class="disable" onclick="cancelWarn()"/>
							</td>
							 
						  </tr>
				</table></div>
        </div>
    </div>
    <div class="uk-panel uk-panel-box" style="padding:5px;margin-top:5px">
        <div class="uk-grid">
		<table style="text-align:center;width:100%" id="log_t">
		<tr style="font-size=14px;font-weight:900"><td style="width:20%">报警时间</td><td style="width:10%">报警类型</td><td style="width:50%">处理情况</td><td style="width:10%">处理类型</td><td style="width:10%">处理人</td></tr>
		</table>
           <!-- <div class="uk-width-1-5" style="width:10%">
                <dl class="uk-description-list-vertical" id="wtime">
                    <dt style="text-align:center">报警时间</dt>
					<dd></dd>
                </dl>
            </div>
            <div class="uk-width-1-5" style="width:10%">
                <dl class="uk-description-list-vertical" id="wtype">
                    <dt style="text-align:center">报警类型</dt>
					<dd></dd>
                </dl>
            </div>
            <div class="uk-width-1-5" style="width:60%">
                <dl class="uk-description-list-vertical" id="wmark">
                    <dt style="text-align:center">处理情况</dt>
					<dd></dd>
                </dl>
            </div>
            <div class="uk-width-1-5" style="width:10%">
                <dl class="uk-description-list-vertical" id="mtype">
                    <dt style="text-align:center">处理类型</dt>
					<dd></dd>
                </dl>
            </div>
            <div class="uk-width-1-5" style="width:10%">
                <dl class="uk-description-list-vertical" id="madmin">
                    <dt style="text-align:center">处理人</dt>
                    <dd></dd>
                </dl>
            </div>-->
        </div>

    </div>
	
	<div id="div3" style="display:none">
		<span id='selectedMid'></span>
		<span id='wlogid'></span>
	</div>
	<div id="div1" ><embed src="http://203.88.170.163:8080/images/warn.mp3" loop="0" autostart="1" hidden="true"></embed>></div>
	<div id="div2" style="display:none"></div>
@endsection

@section('js')
    <script src="{{ asset('/js/components/form-select.min.js') }}"></script>
    <script src="{{ asset('/js/core/dropdown.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.1.7.2.min.js') }}"></script>
    <script src="{{ asset('/js/core/tab.min.js') }}"></script>
    <script src="{{ asset('/js/components/lightbox.min.js') }}"></script>
    <script src="{{ asset('/js/components/search.min.js') }}"></script>
	<script language="javascript" src="http://webapi.amap.com/maps?v=1.3&key=d99080f56defbf2c0c886eb595ad7786"></script>
	<script language="javascript">
var ajaxUrl = '/api/warn-data';  
var ajaxUrl2 = '/api/member-data';
var ajaxUrl3 = '/api/cancel-warn';
var mapObj;
var data="";
function refreshDate(){
var unamestr="";
	$.post(ajaxUrl,{},function(data){
		if(data[0]['success']== 'success'){
			mapObj.clearMap();
			for(var i=0;i<data.length;i++){
				var rsname = data[i]['uname'];
				if(data[i]['c_type']=='问题解决'){
					var color='';
				}else if(data[i]['c_type']=='处理中'){
					var color='color:#ff0000';
				}else{
					var color='color:#ff0000';
					//play_click("/images/warn.mp3");
				}
				//"<li><a href=''>小明</a></li>"
				unamestr += "<li><a href='' id='a"+data[i]['userid']+"' style='cursor:pointer;"+color+"' onclick='geocoder("+data[i]['longitude']+","+data[i]['latitude']+","+data[i]['wid']+",a"+data[i]['userid']+")'>"+rsname+"</a></li>";
				var icon = "/images/"+data[i]['icon']+".png";
				marker(data[i]['longitude'],data[i]['latitude'],rsname,icon);
			}
			$("#uname").html(unamestr);
		}else{
			mapObj.clearMap();
			$("#uname").html( "<li><a href=''>没有报警</a></li>");
		}
	},"json")
}




function initDate(){
	var unamestr="";
	$.post(ajaxUrl,{},function(data){
		if(data[0]['success']== 'success'){
			for(var i=0;i<data.length;i++){
				var rsname = data[i]['uname'];
				if(data[i]['c_type']!='问题解决'){
					var color='color:#ff0000';
				}else{
					var color='';
				}
				unamestr += "<li><a href='' id='a"+data[i]['userid']+"' style='cursor:pointer;"+color+"' onclick='geocoder("+data[i]['longitude']+","+data[i]['latitude']+","+data[i]['wid']+",a"+data[i]['userid']+")'>"+rsname+"</a></li>";
				var icon = "/images/"+data[i]['icon']+".png";
				marker(data[i]['longitude'],data[i]['latitude'],rsname,icon);			
			}
			geocoder(data[0]['longitude'],data[0]['latitude'],data[0]['wid'],'a'+data[0]['userid']);
			$("#uname").html(unamestr);
		}else{
			$("#uname").html( "<li><a href=''>没有报警</a></li>");
		}
	},"json")
}


$(function(){
	mapObj = new AMap.Map("iCenter", {//初始化地图
		view: new AMap.View2D({
		center:new AMap.LngLat(113.56341773223333,34.80699943333),//地图中心点
		zoom:5 //地图显示的缩放级别
		})
    });
	mapObj.setFitView();
	initDate();
	timeid = window.setInterval(refreshDate,15000);
})



function geocoder(longitude,latitude,wid,id) {
	$('#solve').val('');
	var lnglatXY = new AMap.LngLat(longitude,latitude);
    var MGeocoder;
    //加载地理编码插件
    mapObj.plugin(["AMap.Geocoder"], function() {        
        MGeocoder = new AMap.Geocoder({ 
            radius: 1000,
            extensions: "all"
        });
        //返回地理编码结果 
        AMap.event.addListener(MGeocoder, "complete", geocoder_CallBack); 
        //逆地理编码
        MGeocoder.getAddress(lnglatXY); 
    });
	
	mapObj.setZoomAndCenter(16,lnglatXY);
	$.post(ajaxUrl2,{mid:wid},function(data){
		if(data[0]['success']!=='fail'){
			$("#uname1").html(data[0]['uname']);
			$("#tel").html(data[0]['tel']);
			$("#spo2").html(data[0]['spo2']);
			$("#heartrate").html(data[0]['heartrate']);
			$("#skin").html(data[0]['skin']);
			$("#ccid").html(data[0]['ccid']);
			$("#type_str").html(data[0]['type_str']);
			$("#c_type").html(data[0]['c_type']);
			$("#sex").html(data[0]['sex']);
			$("#gps_type").html(data[0]['gps_type']);
			$("#wear_type").html(data[0]['wear_type']);
			$("#time").html(data[0]['time']);
			$("#breath").html(data[0]['breath']);
			$("#name1").html(data[0]['relationship'][0]['name']);
			$("#phone1").html(data[0]['relationship'][0]['phone']);
			$("#name2").html(data[0]['relationship'][1]['name']);
			$("#phone2").html(data[0]['relationship'][1]['phone']);
			$("#swarn").html(data[0]['uname']+' 处理情况');
			$('#selectedMid').html(wid);
			$('#log_t').html('');
			var log_str='<tr style="font-size=14px;font-weight:900"><td style="width:20%">报警时间</td><td style="width:10%">报警类型</td><td style="width:50%">处理情况</td><td style="width:10%">处理类型</td><td style="width:10%">处理人</td></tr>';
			if(data[0]['log'][0]['success']!==0){	
				for(var i=0;i<data[0]['log'].length;i++){
					log_str +='<tr><td>'+data[0]['log'][i]['time_w']+'</td><td>'+data[0]['log'][i]['type']+'</td><td style="text-align:left">'+data[0]['log'][i]['mark']+'('+data[0]['log'][i]['time']+')</td><td>'+data[0]['log'][i]['mtype']+'</td><td>'+data[0]['log'][i]['admin']+'</td></tr>';
				}
				$('#log_t').html(log_str);
			}else{
				$('#log_t').html(log_str);
			}
			if(data[0]['c_type']=='问题解决'){
				$('.disable').attr("disabled","disabled");
			}else{
				$('.disable').removeAttr("disabled");
			}
		}
	},"json")
	
	//$("div").removeClass('color');
	//$(id).addClass('color');
	
}



    //加点
function marker(longitude,latitude,name,icon){
	var img=new AMap.Icon({
        image:icon
    });
	var lnglatXY = new AMap.LngLat(longitude,latitude);
    var marker = new AMap.Marker({
        icon: img,
		title:name,
        position: lnglatXY,
        offset: new AMap.Pixel(-5,-30)
    });
    marker.setMap(mapObj);
}


//回调函数
function geocoder_CallBack(data) {
    var address;
    //返回地址描述
    address = data.regeocode.formattedAddress;
    $("#result").html(address);
}  

function play_click(url){
    var div = document.getElementById('div1');
    div.innerHTML = '<embed src="'+url+'" loop="0" autostart="true" hidden="true"></embed>';
    var emb = document.getElementsByTagName('EMBED')[0];
	alert(div.innerHTML);
    if (emb) {
 /* 这里可以写成一个判断 wav 文件是否已加载完毕，以下采用setTimeout模拟一下 */
        div = document.getElementById('div2');
        div.innerHTML = 'loading: '+emb.src;
        setTimeout(function(){div.innerHTML='';},1000);
    }
}

function solveWarn(){
	var selectedMid = $('#selectedMid').html();
	var mark = $('#solve').val();
	if(mark == ''){
			alert("请输入内容再提交！");
			return;
	}
	
	$.post(ajaxUrl3,{id:selectedMid,mark:mark,act:'solve'},function(data){
		if(data['sucess']===true){
			alert('提交成功！');
			$('#solve').val('');
			initDate();
		}else{
			alert(data['data']);
		}
	},"json")
}

function cancelWarn(){
	var selectedMid = $('#selectedMid').html();
	var mark = $('#solve').val();
	if(mark == ''){
			alert("请输入内容再提交！");
			return;
	}
	$.post(ajaxUrl3,{id:selectedMid,mark:mark,act:'cancel'},function(data){
		if(data['sucess']===true){
			alert('提交成功！!');
			$('#solve').val('');
			initDate();
		}else{
			alert(data['data']);
		}
	},"json")
}

</script>
@endsection