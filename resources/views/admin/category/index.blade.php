<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
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
<style type="text/css">
	.laytable-cell-1-picurl{
		height: 100%;
		max-width: 100%;
	}
</style>
<title>分类列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 分类管理 <span class="c-gray en">&gt;</span> 分类列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"> <a class="btn btn-primary radius" onclick="category_add('添加分类','/admin/category/create')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加分类</a></span> <span class="r">共有数据：<strong>0</strong> 条</span> </div>
	<div class="mt-20">
		<table id="categoryTable" class="layui-table" lay-filter="categoryTable"></table>
	</div>
</div>
<style type="text/css">
    .layui-table-cell{
        text-align:center;
        height: auto;
        white-space: normal;
    }
</style>
<!--_footer 作为公共模版分离出去-->
<!-- <script type="text/javascript" src="{{asset('/js/jquery1.4.2.js')}}"></script>  -->
<script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js">
// <script type="text/javascript" src="{{asset('/lib/jquery/1.9.1/jquery.min.js')}}"></script> 
<script type="text/javascript" src="{{asset('/lib/layer/2.4/layer.js')}}"></script>
<script type="text/javascript" src="{{asset('/static/h-ui/js/H-ui.min.js')}}"></script> 
<script type="text/javascript" src="{{asset('/static/h-ui.admin/js/H-ui.admin.js')}}"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="{{asset('/lib/My97DatePicker/4.8/WdatePicker.js')}}"></script> 
<script type="text/javascript" src="{{asset('/lib/datatables/1.10.0/jquery.dataTables.min.js')}}"></script> 
<script type="text/javascript" src="{{asset('/lib/laypage/1.2/laypage.js')}}"></script>

<script type="text/javascript" src="{{asset('/layui/layui.js')}}"></script>

<script type="text/javascript">

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
                treeIdName: 'id',//id字段的名称
                treePidName: 'parent_id',//pid字段的名称
                treeDefaultClose: false,//是否默认折叠
                treeLinkage: true,//父级展开时是否自动展开所有子级
                elem: '#categoryTable',
                // url: '/layui/module/data.json',
                url: '/api/category',
                page: false,
                cols: [[
                    {type: 'numbers', title: '编号'},
                    {field: 'title', title: '名称'},
                    {field: 'icon', title: '图标', templet: showIcon},
                    {field: 'level', title: '等级'},
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
            treetable.expandAll('#categoryTable');
        });

        $('#btn-fold').click(function () {
            treetable.foldAll('#categoryTable');
        });

        $('#btn-refresh').click(function () {
            renderTable();
        });
		function showIcon(d){
			if(d.icon !== "") {
				return `<div><img src="` + d.icon + `"></div>`
			} else {
				return ''
			}
		}
        
        function complain(d){//操作中显示的内容
        	if(d.parent_id !== 0){
        		return [
                        '<a class="operation" lay-event="edit" href="javascript:void(0)" onclick="category_edit(\''+ d.id + '\')" title="编辑">',
            	     	'<i class="layui-icon layui-icon-edit"></i></a>',
            	     	'<a class="operation" lay-event="" href="javascript:void(0)" onclick="category_del(\''+ d.id + '\')" title="删除">',
            	     	'<i class="layui-icon layui-icon-delete" ></i></a>',
            	     	].join('');
        	} else {
        		return '';
        	}
        }
        //监听工具条
        table.on('tool(categoryTable)', function (obj) {
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
function category_edit(id){
	url = "/admin/category/" + id + "/edit"
	console.log(url)
	var index = layer.open({
		type: 2,
		title: '编辑',
		content: url
	});
	layer.full(index);
}

/*分类-删除*/
function category_del(id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'POST',
			url: '/admin/category/del',
			dataType:'JSON',
			data: {
				'_token':'{{csrf_token()}}',
				'id': id
			},
			success: function(data){
				console.log('success')
				// $(obj).parents("tr").remove();
				layer.msg('已删除!',{icon:1,time:1000});
			},
			error:function(data) {
				console.log(data.msg);
			},
		});	
		return false;	
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