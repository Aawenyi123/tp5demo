<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:85:"C:\myphp_www\PHPTutorial\WWW\tp5\public/../application/index\view\user\user_edit.html";i:1561793293;s:72:"C:\myphp_www\PHPTutorial\WWW\tp5\application\index\view\public\base.html";i:1561699501;s:72:"C:\myphp_www\PHPTutorial\WWW\tp5\application\index\view\public\meta.html";i:1561524039;s:74:"C:\myphp_www\PHPTutorial\WWW\tp5\application\index\view\public\footer.html";i:1561709989;}*/ ?>
<!-- 基础模板只需要 Include block -->
<!--_meta 作为公共模版分离出去-->
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<link rel="Bookmark" href="favicon.ico" >
<link rel="Shortcut Icon" href="favicon.ico" />
<!--[if lt IE 9]>
<script type="text/javascript" src="/static/lib/html5.js"></script>
<script type="text/javascript" src="/static/lib/respond.min.js"></script>
<![endif]-->
<!-- <link rel="stylesheet" type="text/css" href="/static/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/static/static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="/static/lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/static/static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="/static/static/h-ui.admin/css/style.css" /> -->
<link rel="stylesheet" type="text/css" href="/static/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/static/static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="/static/lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/static/static/h-ui.admin/skin/default/skin.css" />
<link rel="stylesheet" type="text/css" href="/static/static/h-ui.admin/css/style.css" />
<!--[if IE 6]>
<script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<!--/meta 作为公共模版分离出去-->


<title>编辑管理员 - 管理员管理 - H-ui.admin v3.0</title>
<meta name="keywords" content="<?php echo (isset($keywords) && ($keywords !== '')?$keywords:'关键字'); ?>">
<meta name="description" content="<?php echo (isset($description) && ($description !== '')?$description:'描述'); ?>">
</head>
<body>




<article class="cl pd-20">
	<?php if($data['empty'] == 0): ?>
	<form action="" method="post" class="form form-horizontal" id="form-admin-add">
		<input type="hidden" name="userId" id="" class="uid" value="<?php echo $data['info']['id']; ?>">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>管理员名：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text name" value="<?php echo $data['info']['name']; ?>" 
					<?php if(\think\Session::get('user_id') == $data['info']['id']): ?>
						disabled="disabled" 
					<?php endif; ?>
				 placeholder="" id="adminName" name="name">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>密码：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="password" class="input-text password" value="<?php echo $data['info']['password']; ?>" autocomplete="off" placeholder="密码" id="password" name="password" >
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>邮箱：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text email" placeholder="@" name="email" id="email" value="<?php echo $data['info']['email']; ?>">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">角色：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
				<select class="select role" name="role" size="1" 
					<?php if(\think\Session::get('user_id') == 1 and $data['info']['id'] != 1): else: ?>
					disabled="disabled" 
					<?php endif; ?>
				 >
					<option value="1" 
					 <?php if($data['info']['role'] == '1'): ?>selected<?php endif; ?>
					>管理员</option>
					<option value="2" 
					 <?php if($data['info']['role'] == '2'): ?>selected<?php endif; ?>
					>超级管理员</option>
				</select>
				</span> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">是否启用：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
				<select class="select status" name="status" size="1"  
				<?php if(\think\Session::get('user_id') == $data['info']['id']): ?>
				disabled="disabled"
				<?php endif; ?>
				>
					<option value="0" 
					 <?php if($data['info']['status'] == '0'): ?>selected<?php endif; ?>
					>启用</option>
					<option value="1" 
					 <?php if($data['info']['status'] == '1'): ?>selected<?php endif; ?>
					>不启用</option>
				</select>
				</span> </div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				<input class="btn btn-primary radius add" type="button" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
			</div>
		</div>
	</form>
	<?php else: ?>
		<h2><?php echo $data['msg']; ?></h2>
	<?php endif; ?>
</article>


<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/static/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/static/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/static/static/h-ui/js/H-ui.js"></script>
<script type="text/javascript" src="/static/static/h-ui.admin/js/H-ui.admin.page.js"></script>
<!-- <script type="text/javascript" src="/static/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/static/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/static/static/h-ui/js/H-ui.js"></script> 
<script type="text/javascript" src="/static/static/h-ui.admin/js/H-ui.admin.page.js"></script>  -->
<!--/_footer /作为公共模版分离出去-->



<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/static/lib/jquery.validation/1.14.0/jquery.validate.js"></script> 
<script type="text/javascript" src="/static/lib/jquery.validation/1.14.0/validate-methods.js"></script> 
<script type="text/javascript" src="/static/lib/jquery.validation/1.14.0/messages_zh.js"></script> 
<script type="text/javascript">
$(function(){
	$('.btn-primary.add').on('click', function () {
		var data = {};
		data.name = $('.name').val();
		data.role = $('.role').val();
		data.status = $('.status').val();
		data.password = $('.password').val();
		data.email = $('.email').val();
		data.userId = $('.uid').val();
		console.log(data);
		$.ajax({
			type: 'POST',
			url: "<?php echo url('user/userUpdate'); ?>",
			data: data,
			dataType: 'json',
			success: function (data) {
				// console.log(data.data);
				if (data.status == 0)
				{
					// layer.closeAll();
					// closeWindow();
					alert(data.msg);
					setTimeout(function () {
						parent.layer.closeAll();
					}, 300);
				} else {
					alert(data.msg);
				}
			}
		});
	});
	// function closeWindow() {
	// 	console.log('close');
		
	// 	parent.layer.closeAll();
	// }
	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
	});
	$("#form-admin-add").validate({
		rules:{
			name:{
				required:true,
				minlength:4,
				maxlength:16
			},
			password:{
				required:true,
			},
			email:{
				required:true,
				email:true,
			},
			role:{
				required:true,
			},
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
			$(form).ajaxSubmit();
			var index = parent.layer.getFrameIndex(window.name);
			parent.$('.btn-refresh').click();
			parent.layer.close(index);
		}
	});
});
</script>
<!--/请在上方写此页面业务相关的脚本-->

</body>
</html>