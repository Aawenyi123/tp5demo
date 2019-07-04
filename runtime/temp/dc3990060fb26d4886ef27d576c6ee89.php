<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:87:"C:\myphp_www\PHPTutorial\WWW\tp5\public/../application/index\view\grand\grand_show.html";i:1561979240;}*/ ?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="lib/html5.js"></script>
<script type="text/javascript" src="lib/respond.min.js"></script>
<![endif]-->
<link href="/static/static/h-ui/css/H-ui.min.css" rel="stylesheet" type="text/css" />
<link href="/static/static/h-ui.admin/css/H-ui.admin.css" rel="stylesheet" type="text/css" />
<link href="/static/lib/Hui-iconfont/1.0.8/iconfont.css" rel="stylesheet" type="text/css" />
<!--[if IE 6]>
<script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script><![endif]-->
<title>班级查看</title>
</head>
<body>
<?php if($data['empty'] == 1): ?>
  <p><?php echo $data['msg']; ?></p>
<?php else: ?>
<div class="cl pd-20" style=" background-color:#5bacb6">
  <dl style="margin-left:80px; color:#fff">
    <dt><span class="f-18"><?php echo $data['info']['name']; ?></span> <span class="pl-10 f-12"><?php echo $data['info']['detail']; ?></span></dt>
    <dd class="pt-10 f-12" style="margin-left:0">创建人：<?php echo $data['info']['creator_name']; ?></dd>
    <dd class="pt-10 f-12" style="margin-left:0">开设课程：<?php echo $data['info']['programName']; ?></dd>
    <dd class="pt-10 f-12" style="margin-left:0">任教教师：<?php echo $data['teacherNames']; ?></dd>
  </dl>
</div>
<div class="pd-20">
    <p>学生表--共计<?php echo $data['countStudent']; ?>名学生</p>
    <table class="table table-border table-bordered table-hover table-bg table-sort">
    <thead>
      <tr class="text-c">
        <th width="80">ID</th>
        <th width="100">用户名</th>
        <th width="40">性别</th>
        <th width="90">手机</th>
        <th width="150">邮箱</th>
        <th width="">地址</th>
        <th width="130">加入时间</th>
      </tr>
    </thead>
      <tbody>
        <?php if(is_array($data['studentList']) || $data['studentList'] instanceof \think\Collection || $data['studentList'] instanceof \think\Paginator): if( count($data['studentList'])==0 ) : echo "" ;else: foreach($data['studentList'] as $key=>$student): ?>
        <tr class="text-c">
          <td><?php echo $student['id']; ?></td>
          <td><?php echo $student['name']; ?></td>
          <td>
              <?php if($student['sex'] == 0): ?>未知<?php endif; if($student['sex'] == 1): ?>男<?php endif; if($student['sex'] == 2): ?>女<?php endif; ?>
          </td>
          <td><?php echo $student['tel']; ?></td>
          <td><?php echo $student['email']; ?></td>
          <td><?php echo $student['address']; ?></td>
          <td><?php echo date('Y-m-d H:i:s',$student['create_time']); ?></td>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; ?>
      </tbody>
    </table>
</div>

<?php endif; ?>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/static/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/static/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/static/static/h-ui/js/H-ui.js"></script>
<script type="text/javascript" src="/static/static/h-ui.admin/js/H-ui.admin.page.js"></script>
<script type="text/javascript" src="/static/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/static/lib/laypage/1.2/laypage.js"></script>
<!--/_footer /作为公共模版分离出去-->
<script type="text/javascript">
$(function () {
  $('.table-sort').dataTable({
    "aaSorting": [[ 1, "desc" ]],//默认第几个排序
    "bStateSave": true,//状态保存
    "aoColumnDefs": [
      //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
      {"orderable":false,"aTargets":[]}// 制定列不参与排序
    ]
  });
});
</script>
</body>
</html>