<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="lib/html5shiv.js"></script>
<script type="text/javascript" src="lib/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="{{asset('/static/h-ui/css/H-ui.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('/static/h-ui.admin/css/H-ui.admin.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('/lib/Hui-iconfont/1.0.8/iconfont.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('/static/h-ui.admin/skin/default/skin.css')}}" id="skin" />
<link rel="stylesheet" type="text/css" href="{{asset('/static/h-ui.admin/css/style.css')}}" />
<!--[if IE 6]>
<script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>楼层商品列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 楼层商品管理 <span class="c-gray en">&gt;</span> 楼层商品列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"> <a class="btn btn-primary radius" onclick="floorlist_add('添加楼层商品','/admin/home/floorlist/create')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加楼层商品</a></span> <span class="r">共有数据：<strong>0</strong> 条</span> </div>
	<div class="mt-20">
		<table class="table table-border table-bordered table-bg table-hover table-sort">
			<thead>
				<tr class="text-c">
					<th width="80">ID</th>
					<th width="80">名称</th>
					<th width="80">楼层分类ID</th>
					<th width="80">楼层商品图</th>
					<th width="150">更新时间</th>
					<th width="100">操作</th>
				</tr>
			</thead>
			<tbody>
				@foreach($floorlists as $floorlist)
					<tr class="text-c">
						<td>{{$floorlist->id}}</td>
					    <td>{{$floorlist->name}}</td>
					    <td>{{$floorlist->floor_id}}</td>
						<td>
							<img width="210" class="floorlist-thumb" src="{{$floorlist->image_src}}">
						</td>
					    <td>{{$floorlist->updated_at}}</td>
						<td class="td-manage"><a style="text-decoration:none" onClick="floorlist_stop(this,'10001')" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6de;</i></a> <a style="text-decoration:none" class="ml-5" onClick="floorlist_edit('修改楼层商品','/admin/home/floorlist/{{$floorlist->id}}/edit')" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a> <a style="text-decoration:none" class="ml-5" onClick="floorlist_del(this,'{{$floorlist->id}}')" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
				    </tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="{{asset('/lib/jquery/1.9.1/jquery.min.js')}}"></script> 
<script type="text/javascript" src="{{asset('/lib/layer/2.4/layer.js')}}"></script>
<script type="text/javascript" src="{{asset('/static/h-ui/js/H-ui.min.js')}}"></script> 
<script type="text/javascript" src="{{asset('/static/h-ui.admin/js/H-ui.admin.js')}}"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="{{asset('/lib/My97DatePicker/4.8/WdatePicker.js')}}"></script> 
<script type="text/javascript" src="{{asset('/lib/datatables/1.10.0/jquery.dataTables.min.js')}}"></script> 
<script type="text/javascript" src="{{asset('/lib/laypage/1.2/laypage.js')}}"></script>
<script type="text/javascript">
$('.table-sort').dataTable({
	"aaSorting": [[ 0, "desc" ]],//默认第几个排序
	"bStateSave": true,//状态保存
	"aoColumnDefs": [
	  //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
	  {"orderable":false,"aTargets":[1, 2, 3, 4, 5]}// 制定列不参与排序
	]
});

/*楼层商品-添加*/
function floorlist_add(title,url){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}

/*楼层商品-查看*/
function floorlist_show(title,url,id){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}

/*楼层商品-编辑*/
function floorlist_edit(title,url){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}

/*楼层商品-删除*/
function floorlist_del(obj, id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'DELETE',
			url: '/admin/home/floorlist/' + id,
			data: {
				'_token':'{{csrf_token()}}'
			},
			success: function(data){
				$(obj).parents("tr").remove();
				layer.msg('已删除!',{icon:1,time:1000});
			},
			error:function(data) {
				console.log(data.msg);
			},
		});		
	});
}
/*批量删除 */
function batchDel() {
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'DELETE',
			url: '/admin/home/floorlist/' + id,
			data: {
				'_token':'{{csrf_token()}}'
			},
			success: function(data){
				$(obj).parents("tr").remove();
				layer.msg('已删除!',{icon:1,time:1000});
			},
			error:function(data) {
				console.log(data.msg);
			},
		});		
	});
}
</script>
</body>
</html>