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
<!--[if IE 6]>
<script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>新增轮播图</title>
<link href="{{asset('lib/webuploader/0.1.5/webuploader.css')}}" rel="stylesheet" type="text/css" />
<style>
	.error {
		color: red;
	}
</style>
</head>
<body>
<div class="page-container">
	<form class="form form-horizontal" id="form-article-add" 
	action="/admin/home/swiper/{{$swiper->id}}" enctype="multipart/form-data" method="post">
		<input type="hidden" name="_method" value="put" />
				        {{ csrf_field() }}           
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">跳转链接：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" 
				value="{{$swiper?$swiper->navigator_url:''}}" placeholder="" id="" name="navigator_url">
				@if ($errors->has('navigator_url'))
				    <p class="error">{{ $errors->first('navigator_url') }}</p>
				@endif
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>跳转方式：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<span class="select-box">
					<select name="open_type" class="select">
						<option value="navigate">navigate</option>
						<option value="redirect">redirect</option>
						<option value="switchTab">switchTab</option>
						<option value="reLaunch">reLaunch</option>
						<option value="navigateBack">navigateBack</option>
					</select>
				</span>

			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">商品ID：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" 
				value="{{$swiper?$swiper->goods_id:''}}" placeholder="" id="" name="goods_id">
				@if ($errors->has('goods_id'))
				    <p class="error">{{ $errors->first('goods_id') }}</p>
				@endif
			</div>
		</div>
	
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">轮播图：</label>
			<div class="formControls col-xs-8 col-sm-9" style="margin-bottom: 20px">
				<span class="btn-upload">
				  <a href="javascript:void();" class="btn btn-primary radius btn-upload"><i class="Hui-iconfont">&#xe642;</i> 浏览文件</a>
				  <input id="swiper-edit-file" type="file" name="file" class="input-file"
				  	value="{{$swiper?$swiper->image_src:''}}">
				</span>
				<div><img id="swiper-edit-img" src="{{$swiper?$swiper->image_src:''}}" width="210" alt=""></div>
				
				<!-- <label for="file">选择文件</label>
		        <input type="file" class="form-control" name="file" 
		        	value="{{$swiper?$swiper->image_src:''}}" accept="image/*"> -->
		        	
		        
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
<script type="text/javascript">
function article_save(){
	alert("刷新父级的时候会自动关闭弹层。")
	window.parent.location.reload();
}

$('#swiper-edit-file').change(function() {
	let file = this.files[0];
        let reader = new FileReader();
        //新建 FileReader 对象
        reader.onload = function(){
          // 当 FileReader 读取文件时候，读取的结果会放在 FileReader.result 属性中
          document.querySelector('#swiper-edit-img').src = this.result;
          // document.querySelector('#text').innerHTML = this.result;
        };
        reader.readAsDataURL(file);
});
</script>
</body>
</html>