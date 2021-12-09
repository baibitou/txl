<?php
include("./includes/common.php");
include("./includes/txprotect.php");
$qq=isset($_GET['qq'])?strip_tags($_GET['qq']):null;

$addsalt=md5(mt_rand(0,999).time());
$_SESSION['addsalt']=$addsalt;

$rs=$DB->query("SELECT * FROM shua_tools WHERE active=1 order by sort asc");
$select='';
while($res = $DB->fetch($rs)){
	$shua_func[$res['tid']]=$res['name'];
	$select.='<option value="'.$res['tid'].'" price="'.$res['price'].'" alert="'.$res['alert'].'" inputname="'.$res['input'].'" inputsname="'.$res['inputs'].'">'.$res['name'].'</option>';
}
@header('Content-Type: text/html; charset=UTF-8');
?>
<?php
$strtotime=strtotime($conf['build']);//获取开始统计的日期的时间戳
$now=time();//当前的时间戳
$yxts=ceil(($now-$strtotime)/86400);//取相差值然后除于24小时(86400秒)
$count1=$DB->count("SELECT count(*) from shua_orders");
$count2=$DB->count("SELECT count(*) from shua_orders where status>=1");
?>
<!doctype html>
<html lang="en" class="fixed">

<head>
<body>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title><?php echo $conf['sitename']?> - <?php echo $conf['title']?></title>
    <meta name="keywords" content="<?php echo $conf['keywords']?>">
    <meta name="description" content="<?php echo $conf['description']?>">
	<link rel="stylesheet" type="text/css" href="http://apps.bdimg.com/libs/bootstrap/3.3.4/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/font-awesome/4.6.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendor/animate.css/animate.css">
    <link rel="stylesheet" href="assets/stylesheets/css/style.css">
</head>

<body>

     

<div class="wrap">
    <div class="page-header">
        <div class="leftside-header">
            <div class="logo">
                <a href="/" class="on-click">
                    <img alt="logo" src="assets/img/logo.png" />
                </a>
            </div>
            <div id="menu-toggle" class="visible-xs toggle-left-sidebar" data-toggle-class="left-sidebar-open" data-target="html">
                <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
            </div>
        </div>
        <div class="rightside-header">
            <div class="header-middle"></div>

            <div class="header-section" id="user-headerbox">
                <div class="user-header-wrap">
                    <div class="user-photo">
                        <img src="http://q2.qlogo.cn/headimg_dl?bs=qq&dst_uin=<?php echo $conf['kfqq']?>&src_uin=<?php echo $conf['kfqq']?>&fid=<?php echo $conf['kfqq']?>&spec=100&url_enc=0&referer=bu_interface&term_type=PC" alt="Mokewl" />
                    </div>
                    <div class="user-info">
                        <span class="user-name">在线联系客服</span>
                        <span class="user-profile">QQ：<?php echo $conf['kfqq']?></span>
                    </div>
				<i class="fa fa-chevron-right icon-open" aria-hidden="true"></i>
                </div>
            </div>
            <div class="header-separator"></div>
            <div class="header-section">
                <a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['kfqq']?>&site=qq&menu=yes"><i class="fa fa-qq log-out" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="left-sidebar">
            <div class="left-sidebar-header">
                <div class="left-sidebar-title">菜单导航</div>
                <div class="left-sidebar-toggle c-hamburger c-hamburger--htla hidden-xs" data-toggle-class="left-sidebar-collapsed" data-target="html">
                    <span></span>
                </div>
            </div>
            <div id="left-nav" class="nano">
                <div class="nano-content">
                    <nav>
                        <ul class="nav" id="main-nav">
                            <li><a href="index.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>在线下单</span></a></li>
                             <li><a href="kami.php"><i class="fa fa-credit-card" aria-hidden="true"></i><span>卡密下单</span></a></li>
							<li><a href="cxdd.php"><i class="fa fa-search" aria-hidden="true"></i><span>订单查询</span></a></li>
							 <li class="active-item"<?php if(empty($conf['lqqapi'])){?> data-toggle="tab" style="display:none;"<?php }?>><a href="lqq.php"><i class="fa fa-circle-o-notch" aria-hidden="true"></i><span>拉圈圈赞</span></a></li>
							 <li><a href="#about" onclick="javascript:alert('未开启！')"><i class="fa fa-comments-o" aria-hidden="true"></i><span>交流社区</span></a></li>
							 <li><a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['kfqq']?>&site=qq&menu=yes"><i class="fa fa-qq" aria-hidden="true"></i><span>联系客服</span></a></li>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="content-header">
                <div class="leftside-content-header">
                    <ul class="breadcrumbs">
                        <li><i class="fa fa-tachometer" aria-hidden="true"></i><a href="/"><?php echo $conf['sitename']?></a></li>
                        <li><a href="#">拉圈圈99+</a></li>
                    </ul>
                </div>
            </div>
            <div class="animated fadeInUp">
							    <div class="panel b-info b-md">
<table class="table table-bordered">
<tbody>
<tr>
	<td align="center"><font color="#808080"><b>平台已经运营</b></br><i class="fa fa-bar-chart-o fa-2x"></i></br><?php echo $yxts?>天</font></td>
	<td align="center"><font color="#808080"><b>业务订单总数</b></br><span class="fa fa-shopping-cart fa-2x"></span></br><?php echo $count1?>条</font></td>
         <td align="center"><font color="#808080"><b>已处理的订单</b></br><i class="fa fa-check-square-o fa-2x"></i></span></br><?php echo $count2?>条</font></td>
<tbody>
</table>
</div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="panel">
                            <div class="panel-header  panel-danger">
                                <h3 class="panel-title">平台公告</h3>
                                <div class="panel-actions">
                                    <ul>
                                        <li class="action toggle-panel panel-expand"><span></span></li>
                                        <li class="action"><span class="fa fa-bars action" aria-hidden="true"></span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-content">
                            <?php echo $conf['anounce']?>
							<?php echo $conf['bottom']?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="panel">
                            <div class="panel-header  panel-info">
                                <h3 class="panel-title">拉圈圈99+</h3>
                                <div class="panel-actions">
                                    <ul>
                                        <li class="action toggle-panel panel-expand"><span></span></li>
                                        <li class="action"><span class="fa fa-bars action" aria-hidden="true"></span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-content">
		<div class="tab-pane fade in" id="lqq">
			<div class="form-group">
				<label for="password">请输入QQ</label>
				<input type="text" name="qq" id="qq4" value="" class="form-control" required/>
			</div>
			<input type="submit" id="submit_lqq" class="btn btn-primary btn-block" value="立即提交">
			<div id="result3" class="form-group" style="display:none;"></div>
		</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="#" class="scroll-to-top"><i class="fa fa-angle-double-up"></i></a>
    </div>
</div>
<script src="assets/javascripts/jquery.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendor/nano-scroller/nano-scroller.js"></script>
<script src="assets/javascripts/template-script.min.js"></script>
<script src="assets/javascripts/template-init.min.js"></script>
<script type="text/javascript">
function getPoint() {
	var price = $('#tid option:selected').attr('price');
	$('#need').val('￥'+price);

}
getPoint();
$(document).ready(function(){
	
	$("#submit_lqq").click(function(){
		var qq=$("#qq4").val();
		if(qq==''){alert('QQ号不能为空！');return false;}
		if(qq.length<5 || qq.length>11){alert('请输入正确的QQ号！');return false;}
		$('#result3').hide();
		if($.cookie('lqq') && $.cookie('lqq').indexOf(qq)>=0){
			$('#result3').html('<div class="alert alert-success"><img src="assets/img/ico_success.png">&nbsp;该QQ已经提交过，请勿重复提交！</div>');
			$("#result3").slideDown();
			return false;
		}
		$('#submit_lqq').val('Loading');
		$.ajax({
			type : "POST",
			url : "ajax.php?act=lqq",
			data : {qq:qq,salt:'11aa636c0bfa96617640d63bd5e9f357'},
			dataType : 'json',
			success : function(data) {
				if($.cookie('lqq')){
					$.cookie('lqq', $.cookie('lqq')+'-'+qq);
				}else{
					$.cookie('lqq', qq);
				}
				$('#result3').html('<div class="alert alert-success"><img src="assets/img/ico_success.png">&nbsp;QQ已提交 正在为您排队,可能需要一段时间 请稍后查看圈圈增长情况</div>');
				$("#result3").slideDown();
				$('#submit_lqq').val('立即提交');
			} 
		});
	});
var isModal=true;
if( !$.cookie('op') && isModal==true){
	$('#myModal').modal({
		keyboard: true
	});
	var cookietime = new Date(); 
	cookietime.setTime(cookietime.getTime() + (10*60*1000));
	$.cookie('op', false, { expires: cookietime });
}
});



</script>
</body>

</html>