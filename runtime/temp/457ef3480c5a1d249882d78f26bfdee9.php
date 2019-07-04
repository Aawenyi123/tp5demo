<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:91:"C:\myphp_www\PHPTutorial\WWW\tp5\public/../application/index\view\program\program_edit.html";i:1561899052;s:72:"C:\myphp_www\PHPTutorial\WWW\tp5\application\index\view\public\base.html";i:1561699501;s:72:"C:\myphp_www\PHPTutorial\WWW\tp5\application\index\view\public\meta.html";i:1561524039;s:74:"C:\myphp_www\PHPTutorial\WWW\tp5\application\index\view\public\footer.html";i:1561709989;}*/ ?>
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
	<?php if($data['empty'] == 1): ?>
		<p><?php echo $data['msg']; ?></p>
	<?php else: ?>
	<form action="" method="post" class="form form-horizontal" id="form-member-add">
		<input type="hidden" name="" class="programId" value="<?php echo $data['info']['id']; ?>">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>课程名：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text programName" value="<?php echo $data['info']['name']; ?>" placeholder="" id="username" name="programName">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">
			<span class="c-red">*</span>课程描述：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<textarea name="beizhu" cols="" rows="" class="textarea miaoshu" value="<?php echo $data['info']['detail']; ?>"  placeholder="说点什么...最少输入10个字符"><?php echo $data['info']['detail']; ?></textarea>
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				<input class="btn btn-primary radius" type="button" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
			</div>
		</div>
	</form>
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
		var name = $('.programName').val();
		if (name == '') {
			alert('课程名称不能为空，请检查');
			return false;
		}
		if (detail == '') {
			alert('课程描述不能为空，请检查');
			return false;
		}
		var data = {
			name: name,
			detail: detail,
			// creator_id: $('#userId').val()
			id: $('.programId').val()
		};
		// console.log(data);
		// return false;
		$.ajax({
			type: 'POST',
			url: '<?php echo url('program/programUpdate'); ?>',
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