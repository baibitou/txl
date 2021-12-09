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

     


                            <div class="panel-content">
                            <?php echo $conf['anounce']?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="panel">
                            <div class="panel-header  panel-info">
                                <h3 class="panel-title">在线注册</h3>
                                <div class="panel-actions">
                                    <ul>
                                        <li class="action toggle-panel panel-expand"><span></span></li>
                                        <li class="action"><span class="fa fa-bars action" aria-hidden="true"></span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-content">
			<div class="tab-pane fade in active" id="onlinebuy">
			<div class="form-group">
				<label for="password"><font color="#808080">注册</font></label>
				<select name="tid" id="tid" class="form-control" onchange="getPoint();"><?php echo $select?></select>
			</div>
			<div class="form-group">
				<label for="password"><font color="#808080">幼女阁传媒</font></label>
				
			</div>
			<div class="form-group">
				<font color="#808080"><label for="password" id="inputname">ＱＱ账号</label></font>
				<input type="text" name="inputvalue" id="inputvalue" value="<?php echo $qq?>" class="form-control" required/>
			</div>
			<div class="form-group">
			<div id="inputsname"></div>
			</div>
			<div id="alert_frame" class="alert alert-warning" style="display:none;"></div>
			<div id="pay_frame" class="form-group" style="display:none;"
			</div>
			<div class="form-group">
				<label for="password"><font color="#808080">注册失败请检查网络</font></label>
				
			</div>
			<div class="alert alert-success" id="success"><i class="fa fa-check-circle mr-sm text-md"></i></div>
			
			</div>
			<input type="submit" id="submit_buy" class="btn btn-info btn-block" value="注册">
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
	var alert = $('#tid option:selected').attr('alert');
	if(alert!=''){
		$('#alert_frame').show();
		$('#alert_frame').html(alert);
	}else{
		$('#alert_frame').hide();
	}
	var inputname = $('#tid option:selected').attr('inputname');
	if(inputname!=''){
		$('#inputname').html(inputname);
	}else{
		$('#inputname').html("ＱＱ账号");
	}
	var inputsname = $('#tid option:selected').attr('inputsname');
	if(inputsname!=''){
		$('#inputsname').html("");
		$.each(inputsname.split('|'), function(i, value) {
			$('#inputsname').append('<label for="password" id="inputname"><font color="#808080">'+value+'</font></label><input type="text" name="inputvalue'+(i+2)+'" id="inputvalue'+(i+2)+'" value="" class="form-control" required/>');
		});
		$('#inputsname').show();
	}else{
		$('#inputsname').html("");
		$('#inputsname').hide();
	}
}
getPoint();
$(document).ready(function(){
	$("#submit_buy").click(function(){
		var tid=$("#tid").val();
		var inputvalue=$("#inputvalue").val();
		if(inputvalue=='' || tid==''){alert('请确保每项不能为空！');return false;}
		if($('#inputname').html()=='ＱＱ账号' && (inputvalue.length<5 || inputvalue.length>11)){alert('请输入正确的QQ号！');return false;}
		$('#pay_frame').hide();
		$('#submit_buy').val('Loading');
		$.ajax({
			type : "POST",
			url : "ajax.php?act=pay",
			data : {tid:tid,inputvalue:inputvalue,inputvalue2:$("#inputvalue2").val(),inputvalue3:$("#inputvalue3").val(),inputvalue4:$("#inputvalue4").val(),inputvalue5:$("#inputvalue5").val()},
			dataType : 'json',
			success : function(data) {
				if(data.code == 0){
					$('#alert_frame').hide();
					$('#tid').attr("disabled",true);
					$('#qq1').attr("disabled",true);
					$('#submit_buy').hide();
					$('#orderid').val(data.trade_no);
					$('#needs').val("￥"+data.need);
					
					$("#pay_frame").slideDown();
				}else{
					alert(data.msg);
				}
				$('#submit_buy').val('注册');
			} 
		});
	});
	$("#submit_card").click(function(){
		var km=$("#km").val();
		var qq=$("#qq2").val();
		if(qq=='' || km==''){alert('请确保每项不能为空！');return false;}
		if(qq.length<5 || qq.length>11){alert('请输入正确的QQ号！');return false;}
		$('#submit_card').val('Loading');
		$('#result1').hide();
		$.ajax({
			type : "POST",
			url : "ajax.php?act=card",
			data : {km:km,qq:qq},
			dataType : 'json',
			success : function(data) {
				if(data.code == 0){
					$('#result1').html('<div class="alert alert-success"><img src="assets/img/ico_success.png">&nbsp;'+data.msg+'</div>');
					$("#result1").slideDown();
				}else{
					alert(data.msg);
				}
				$('#submit_card').val('注册');
			} 
		});
	});
$("#buy_alipay").click(function(){
	var orderid=$("#orderid").val();
	window.location.href='other/submit.php?type=alipay&orderid='+orderid;
});
$("#buy_qqpay").click(function(){
	var orderid=$("#orderid").val();
	window.location.href='other/submit.php?type=qqpay&orderid='+orderid;
});
$("#buy_wxpay").click(function(){
	var orderid=$("#orderid").val();
	window.location.href='other/submit.php?type=wxpay&orderid='+orderid;
});
$("#buy_tenpay").click(function(){
	var orderid=$("#orderid").val();
	window.location.href='other/submit.php?type=tenpay&orderid='+orderid;
});
var isModal=<?php echo empty($conf['modal'])?'false':'true';?>;
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