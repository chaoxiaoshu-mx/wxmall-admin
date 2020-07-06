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
<link rel="stylesheet" type="text/css" href="{{asset('/layui/css/layui.css')}}" />

<!--[if IE 6]>
<script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>分类列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 分类管理 <span class="c-gray en">&gt;</span> 分类列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"> <a class="btn btn-primary radius" onclick="category_add('添加分类','/admin/category/create')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加分类</a></span> <span class="r">共有数据：<strong>0</strong> 条</span> </div>
	<div class="mt-20">
		<!-- <table class="table table-border table-bordered table-bg table-hover table-sort">
			<thead>
				<tr class="text-c">
					<th width="80">ID</th>
					<th width="80">名称</th>
					<th width="80">父级分类</th>
					<th width="80">分类等级</th>
					<th width="80">图标</th>
					<th width="150">更新时间</th>
					<th width="100">操作</th>
				</tr>
			</thead>
			<tbody>
				@foreach($categories as $category)
					<tr class="text-c">
						<td>{{$category->id}}</td>
					    <td>{{$category->name}}</td>
					    <td>{{$category->parent_id}}</td>
					    <td>{{$category->level}}</td>
					    <td>
							<img width="100" class="image-thumb" src="{{$category->icon}}">
						</td>
					    <td>{{$category->updated_at}}</td>
						<td class="td-manage"><a style="text-decoration:none" onClick="category_stop(this,'10001')" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6de;</i></a> <a style="text-decoration:none" class="ml-5" onClick="category_edit('修改分类','/admin/home/category/{{$category->id}}/edit')" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a> <a style="text-decoration:none" class="ml-5" onClick="category_del(this,'{{$category->id}}')" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
				    </tr>
				@endforeach
			</tbody>
		</table> -->

		<table id="permissionTable" class="layui-table" lay-filter="permissionTable"></table>
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

<script type="text/javascript" src="{{asset('/layui/layui.js')}}"></script>

<script type="text/javascript">
$('.table-sort').dataTable({
	"aaSorting": [[ 0, "desc" ]],//默认第几个排序
	"bStateSave": true,//状态保存
	"aoColumnDefs": [
	  //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
	  {"orderable":false,"aTargets":[1, 2, 3]}// 制定列不参与排序
	]
});
$(function(){
    layui.config({
        base: '/layui/module/'
    }).extend({
        treetable: 'treetable-lay/treetable'
    }).use(['layer', 'table', 'treetable'], function () {
        var $ = layui.jquery;
        var table = layui.table;
        var layer = layui.layer;
        var treetable = layui.treetable;

        // 渲染表格
        var renderTable = function () {//树桩表格参考文档：https://gitee.com/whvse/treetable-lay
            layer.load(3);
            treetable.render({
                treeColIndex: 1,//树形图标显示在第几列
                treeSpid: 0,//最上级的父级id
                treeIdName: 'permissionId',//id字段的名称
                treePidName: 'pid',//pid字段的名称
                treeDefaultClose: false,//是否默认折叠
                treeLinkage: true,//父级展开时是否自动展开所有子级
                elem: '#permissionTable',
                url: '/layui/module/data.json',
                page: false,
                cols: [[
                    {type: 'numbers', title: '编号'},
                    {field: 'permissionName', title: '资源名称'},
                    {field: 'permissionUrl', title: '资源路径'},
                    {field: 'permissionType', title: '资源简介'},
                    {field: 'pid', title: '排序'},
                    {field: 'resType', title: '类型',
                    	templet: function(d){
                    		if(d.resType==0){
                    			return '菜单';
                    		}else{
                    			return '按钮';
                    		}
                        }	
                    },
                    {templet: complain, title: '操作'}
                ]],
                done: function () {
                    layer.closeAll('loading');
                }
            });
        };

        renderTable();
        
		//触发三个button按钮
        $('#btn-expand').click(function () {
            treetable.expandAll('#permissionTable');
        });

        $('#btn-fold').click(function () {
            treetable.foldAll('#permissionTable');
        });

        $('#btn-refresh').click(function () {
            renderTable();
        });
		
        
        function complain(d){//操作中显示的内容
        	if(true || d.permissionUrl!=null){
        		return [
                        '<a class="operation" lay-event="edit" href="javascript:void(0)" onclick="editDepartment(\''+ d.permissionId + '\')" title="编辑">',
            	     	'<i class="layui-icon layui-icon-edit"></i></a>',
            	     	'<a class="operation" lay-event="" href="javascript:void(0)" onclick="delDepartment(\''+ d.permissionId + '\')" title="删除">',
            	     	'<i class="layui-icon layui-icon-delete" ></i></a>',
            	     	].join('');
        	}else{
        		return '';
        	}
        	
        }
        //监听工具条
        table.on('tool(permissionTable)', function (obj) {
            var data = obj.data;
            var layEvent = obj.event;
			if(data.permissionName!=null){
				if (layEvent === 'del') {
	                layer.msg('删除' + data.id);
	            } else if (layEvent === 'edit') {
	                layer.msg('修改' + data.id);
	            }
			}
        });
    });
})


/*分类-添加*/
function category_add(title,url){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}

/*分类-查看*/
function category_show(title,url,id){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}

/*分类-编辑*/
function category_edit(title,url){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}

/*分类-删除*/
function category_del(obj, id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'DELETE',
			url: '/admin/category/' + id,
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
			url: '/admin/category/' + id,
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