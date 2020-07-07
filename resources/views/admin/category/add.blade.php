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
<link rel="stylesheet" type="text/css" href="{{asset('static/h-ui/css/H-ui.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('static/h-ui.admin/css/H-ui.admin.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('lib/Hui-iconfont/1.0.8/iconfont.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('static/h-ui.admin/skin/default/skin.css')}}" id="skin" />
<link rel="stylesheet" type="text/css" href="{{asset('static/h-ui.admin/css/style.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('/layui/css/layui.css')}}" />

<!--[if IE 6]>
<script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>新增商品</title>
<style>
	.error {
		color: red;
	}
</style>
<style media="screen">
  .tree-txt-active{
    color :red;
  }
</style>
</head>
<body>
<div class="page-container">
	<form class="form form-horizontal" id="form-article-add" action="/admin/category" enctype="multipart/form-data" method="POST">
				        {{ csrf_field() }}    


		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" 
				value="" placeholder="" id="" name="title">
				@if ($errors->has('title'))
				    <p class="error">{{ $errors->first('title') }}</p>
				@endif
			</div>
		</div>
		
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>父级分类：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="hidden" id="parent_id" name="parent_id" value="0">
				<input type="hidden" name="level" value="0">
				<div id="categoryTree"></div>
			</div>
		</div>
	
		
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">图标：</label>
			<div class="formControls col-xs-8 col-sm-9" style="margin-bottom: 20px">
				<label for="file">选择文件</label>
		        <input id="file" type="file" class="form-control" name="file">
		        @if ($errors->has('file'))
				    <p class="error">{{ $errors->first('file') }}</p>
				@endif
			</div>
		</div>

		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
				<button class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存</button>
				<button onClick="layer_close();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
			</div>
		</div>
	</form>
</div>


<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="{{asset('lib/jquery/1.9.1/jquery.min.js')}}"></script> 
<script type="text/javascript" src="{{asset('lib/layer/2.4/layer.js')}}"></script>
<script type="text/javascript" src="{{asset('static/h-ui/js/H-ui.min.js')}}"></script> 
<script type="text/javascript" src="{{asset('static/h-ui.admin/js/H-ui.admin.js')}}"></script> <!--/_footer /作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="{{asset('lib/jquery.validation/1.14.0/jquery.validate.js')}}"></script> 
<script type="text/javascript" src="{{asset('lib/jquery.validation/1.14.0/validate-methods.js')}}"></script> 
<script type="text/javascript" src="{{asset('lib/jquery.validation/1.14.0/messages_zh.js')}}"></script> 
<script type="text/javascript" src="{{asset('lib/webuploader/0.1.5/webuploader.min.js')}}"></script> 
<script type="text/javascript" src="{{asset('/layui/layui.js')}}"></script>

<script src="{{asset('js/request.js')}}"></script>

<script type="text/javascript">



function article_save(){
	alert("刷新父级的时候会自动关闭弹层。")
	window.parent.location.reload();
}
request({url: '/category/tree'})
	.then(result=>{
		var data = result;
		console.log(data)
		layui.use('tree', function(){
		    var tree = layui.tree;
		    
		    //渲染
		    var inst1 = tree.render({
		      elem: '#categoryTree',    //绑定元素
		      onlyIconControl: true,
		      showCheckbox:true,
		      id: 'treeLty',
		      accordion:true,
		      data: data,
		      click: function(obj) {
		      	// console.log(obj.data.parent_id)
		      	showTree(obj.data.id);
		      	$("#parent_id").val(obj.data.id);
		      	console.log($("#parent_id").val());
		      },
		      oncheck: function(obj){
				 $(".layui-form-checked").removeClass("layui-form-checked");
				 $("[name='layuiTreeCheck_"+obj.data.id+"']").next().next().click();
			  }
		    });
		    // tree.setChecked('treeLty', 0);
		    
		  });
	})

	function showTree(id){
		$(".layui-form-checked").removeClass("layui-form-checked");
		var input=$("[name='layuiTreeCheck_"+id+"']");
		input.parents(".layui-tree-pack").show();
		input.parents(".layui-tree-setHide").addClass("layui-tree-spread").find(".layui-icon-addition").removeClass("layui-icon-addition").addClass("layui-icon-subtraction");
		input.next().addClass("layui-form-checked");
		input.parents(".layui-tree-pack").prev().find(".layui-form-checkbox").addClass("layui-form-checked");
	}


</script>
</body>
</html>