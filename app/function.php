<?php
function timeafter($d){
	$d = strtotime($d) - time();
	if($d < 0){
		echo '已过期';
	}elseif($d < 60 ){
		echo $d.'秒';
	}else if($d < 3600){
		echo floor($d/60).'分钟';
	}else if($d < 86400){
		echo floor($d/3600).'小时';
	}else if($d < (3600*24*30)){
		echo floor($d/86400).'天';
	}
}
?>
