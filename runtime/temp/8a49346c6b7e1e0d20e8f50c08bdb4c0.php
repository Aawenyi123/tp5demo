<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:91:"C:\myphp_www\PHPTutorial\WWW\tp5\public/../application/index\view\student\student_edit.html";i:1561960374;s:72:"C:\myphp_www\PHPTutorial\WWW\tp5\application\index\view\public\base.html";i:1561699501;s:72:"C:\myphp_www\PHPTutorial\WWW\tp5\application\index\view\public\meta.html";i:1561524039;s:74:"C:\myphp_www\PHPTutorial\WWW\tp5\application\index\view\public\footer.html";i:1561709989;}*/ ?>
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







<article class="cl pd-20">
	<?php if($data['empty'] == 0): ?>
	<form action="" method="post" class="form form-horizontal" id="form-member-add">
		<input type="hidden" name="" class="studentId" value="<?php echo $data['info']['id']; ?>">	
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>学生名：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text studentName" value="<?php echo $data['info']['name']; ?>" placeholder="" id="username" name="studentName">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>性别：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<select name="sex" class="studentSex" style="width:50px;border-radius:5px;">
					<option value="1" 
					<?php if($data['info']['sex'] == '1'): ?>selected<?php endif; ?>
					>男</option>
					<option value="2" 
					<?php if($data['info']['sex'] == '2'): ?>selected<?php endif; ?>
					>女</option>
				</select>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>手机号：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="number" class="input-text tel" value="<?php echo $data['info']['tel']; ?>" placeholder="" id="tel" name="tel" style="width:200px;">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>email：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="email" class="input-text email" value="<?php echo $data['info']['email']; ?>" placeholder="" id="email" name="email">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>现住地址：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text address" value="<?php echo $data['info']['address']; ?>" placeholder="" id="address" name="addrss">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">
			<span class="c-red"></span>简介：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<textarea name="beizhu" cols="" rows="" value="<?php echo $data['info']['detail']; ?>" class="textarea miaoshu"  placeholder="说点什么...最少输入10个字符"><?php echo $data['info']['detail']; ?></textarea>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">
			<span class="c-red">*</span>添加班级：</label>
			<div class="formControls col-xs-8 col-sm-9" style="border:#e5e5e5 1px solid;border-radius:5px;">
				<?php if($data['count'] == 0): ?>
					<p>未发现班级信息，请添加班级后，再继续绑定</p>
				<?php else: if(is_array($data['grandList']) || $data['grandList'] instanceof \think\Collection || $data['grandList'] instanceof \think\Paginator): if( count($data['grandList'])==0 ) : echo "" ;else: foreach($data['grandList'] as $key=>$grand): ?>
						<span class="pro" style="width:50%;float:left;">
						<?php echo $grand['name']; ?>：<input type="checkbox" name="grandList" value="<?php echo $grand['id']; ?>" 
						<?php if(in_array($grand['id'], $data['grandIds']) == true): ?>checked="checked"<?php endif; ?> 
						>
						</span>
					<?php endforeach; endif; else: echo "" ;endif; endif; ?>
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				<input class="btn btn-primary radius" type="button" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
			</div>
		</div>
	</form>
	<?php else: ?>
		<p><?php echo $data['msg']; ?></p>
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
<script type="text/javascript" src="/static/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/static/lib/jquery.validation/1.14.0/jquery.validate.js"></script> 
<script type="text/javascript" src="/static/lib/jquery.validation/1.14.0/validate-methods.js"></script> 
<script type="text/javascript" src="/static/lib/jquery.validation/1.14.0/messages_zh.js"></script> 
<script type="text/javascript">
$(function(){
	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
	});
	// 添加
	$('.btn-primary').on('click', function () {
		var detail = $('.miaoshu').val();
		var name = $('.studentName').val();
		var sex = $('.studentSex').val();
		var email = $('.email').val();
		var tel = $('.tel').val();
		var address = $('.address').val();
		if (name == '') {
			alert('学生名称不能为空，请检查');
			return false;
		}
		if (email == '') {
			alert('email不能为空，请检查');
			return false;
		}
		if (tel == '') {
			alert('手机号不能为空，请检查');
			return false;
		}
		if (address == '') {
			alert('住址不能为空，请检查');
			return false;
		}
		var l = $('input[name="grandList"][type="checkbox"]:checked').length;
		if (l == 0) {
			alert('未选中课程，请检查');
			return false;
		}
		var grandIds = [];
		for (var i = 0; i < l; i++) {
			var obj = $('input[name="grandList"][type="checkbox"]:checked').eq(i);
			grandIds.push(obj.val());
		}
		grandIds = grandIds.join(',');
		var data = {
			name: name,
			detail: detail,
			sex: sex,
			grandIds: grandIds,
			id: $('.studentId').val(),
			email: email,
			tel: tel,
			address: address
		};
		// return false;
		// console.log(data);
		$.ajax({
			type: 'POST',
			url: '<?php echo url('student/studentUpdate'); ?>',
			data: data,
			dataType: 'json',
			success: function (data) {
				if (data.status == 0) {
					layer.msg(data.msg,{icon: 6,time:500});
					setTimeout(function (){
						parent.layer.closeAll();
					},500);
				} else {
					layer.msg(data.msg,{icon: 5,time:1000});	
				}
			}
		});
	});
});
</script> 
<!--/请在上方写此页面业务相关的脚本-->

</body>
</html>