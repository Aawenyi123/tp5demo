<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:86:"C:\myphp_www\PHPTutorial\WWW\tp5\public/../application/index\view\grand\grand_add.html";i:1561910688;s:72:"C:\myphp_www\PHPTutorial\WWW\tp5\application\index\view\public\base.html";i:1561699501;s:72:"C:\myphp_www\PHPTutorial\WWW\tp5\application\index\view\public\meta.html";i:1561524039;s:74:"C:\myphp_www\PHPTutorial\WWW\tp5\application\index\view\public\footer.html";i:1561709989;}*/ ?>
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




	<input type="hidden" id="userId" value=<?php echo session('user_info.id'); ?>>
	<input type="hidden" id="userRole" value=<?php echo session('user_info.role'); ?>>



<article class="cl pd-20">
	
	<form action="" method="post" class="form form-horizontal" id="form-member-add">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>班级名：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text programName" value="" placeholder="" id="username" name="programName">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">
			<span class="c-red">*</span>班级描述：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<textarea name="beizhu" cols="" rows="" value="" class="textarea miaoshu"  placeholder="说点什么...最少输入10个字符"></textarea>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">
			<span class="c-red">*</span>添加课程：</label>
			<div class="formControls col-xs-8 col-sm-9" style="border:#e5e5e5 1px solid;border-radius:5px;">
				<?php if($data['count'] == 0): ?>
					<p>未发现课程信息，请添加课程后，再继续绑定</p>
				<?php else: if(is_array($data['programList']) || $data['programList'] instanceof \think\Collection || $data['programList'] instanceof \think\Paginator): if( count($data['programList'])==0 ) : echo "" ;else: foreach($data['programList'] as $key=>$program): ?>
						<span class="pro" style="width:20%;float:left;">
						<?php echo $program['name']; ?>：<input type="checkbox" name="programList" value="<?php echo $program['id']; ?>">
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
			alert('班级名称不能为空，请检查');
			return false;
		}
		if (detail == '') {
			alert('班级描述不能为空，请检查');
			return false;
		}
		var l = $('input[name="programList"][type="checkbox"]:checked').length;
		if (l == 0) {
			alert('未选中课程，请检查');
			return false;
		}
		var programIds = [];
		for (var i = 0; i < l; i++) {
			var obj = $('input[name="programList"][type="checkbox"]:checked').eq(i);
			programIds.push(obj.val());
		}
		programIds = programIds.join(',');
		var data = {
			name: name,
			detail: detail,
			programIds: programIds,
			creator_id: $('#userId').val()
		};
		// console.log(data);
		$.ajax({
			type: 'POST',
			url: '<?php echo url('grand/grandSave'); ?>',
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