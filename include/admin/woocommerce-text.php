<?php
//check access
if (!function_exists('is_admin')) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit();
}

//start settings page
function woo_persian_list_text() {
global $wpdb;
$persian_woocommerce_table = $wpdb -> prefix . "woocommerce_ir";
?>
<div class="postbox-container" style="margin: 5px;margin-top: 0px;width: 95%;">
	<div class="metabox-holder">
		<div class="meta-box-sortables">
			<div class="postbox">
				<div class="handlediv">
					<br />
				</div>
				<h3 class="hndle"><span> ویرایش حلقه‌ی ترجمه </span></h3>
				<div class="inside">
<center>
<?php
if($_GET[deleted])
{
$id = explode("|", $_GET[deleted]);
$count=count($id)-1;
for($i=0;$i<$count;$i++)
$sql=mysql_query("DELETE FROM $persian_woocommerce_table WHERE id = ".$id[$i]." LIMIT 1");
if($sql)
echo '<font face="Tahoma" size="3" color="#008000">'.$count.' فیلد ها با موفقیت حذف گردید.</font>';
else
echo '<font face="Tahoma" size="3" color="#FF0000">عملیات حذف با مشکل روبرو شد!</font>';

}
?></center>	

				<table style="border-collapse: collapse;border-spacing: 0;" cellpadding="0" cellspacing="0" width="500" border="0">
					<thead>
						<tr>
							<th scope="col">ردیف</th>
							<th scope="col">حلقه‌ی اصلی</th>
							<th scope="col">حلقه‌ی جایگزین‌شده</th>
						</tr>
					</thead>
						
					<tbody>
<?php
$limit = 10;
$p		=	(int) @$_GET["p"]	;
if ( $p ){$p=$p-1;$pp	=	$p*$limit	;}
else{$pp = 0 ;}
$query	=	mysql_query("select * from $persian_woocommerce_table ORDER BY id DESC");
for ( $i = 0 ; $i < $limit ; $i++ )
	{
	$id			=  	@mysql_result($query,$i+$pp,"id");
		if ( $id != "" )
			{
	$text1	=	@mysql_result($query,$i+$pp,"text1");
	$text2	=	@mysql_result($query,$i+$pp,"text2");

echo <<<HTML
						<tr>
							<td><center><input type="checkbox" name="select" value="$id"></center></td>
							<td><center>$text1</center></td>
							<td><center>$text2</center></td>
						</tr>
HTML;
			}else{break;}
	}
?>
						
						
					</tbody>
				</table><br>
				<button class="button" onClick="group_link();" >پاک‌کردن گزینش‌شده‌ها</button>
				<br>
<?php
if(mysql_num_rows($query)){
echo '<div>';
if(!$_GET[p])
$_GET[p]=1;
$page_nums		=		ceil(mysql_num_rows($query) / $limit) ;
for ( $i = 1 ; $i <= $page_nums ; $i++ )
	{
    if($_GET[p]==$i){
	echo "<a 'style='COLOR: #008000;TEXT-DECORATION: none'><font style='padding: 1px ; text-align: center ; border: 1px solid #000000 ; width: 20px ; cursor: pointer' align='right'>&nbsp;".$i."&nbsp;</font>&nbsp;</a>" ;
	}else{
	echo "<a href='?page=persian-world-edit&p=".$i."' style='COLOR: #FF0000;TEXT-DECORATION: none'><font style='padding: 1px ; text-align: center ; width: 20px ; cursor: pointer' align='right'>&nbsp;".$i."&nbsp;</font>&nbsp;</a>" ;
    }
	if( $i%27 == 0 ){
	echo "<br>";
	}
    }
echo "</div>";
}
?>
<script>
function group_link()
{
	var input = document.getElementsByTagName('input');
	var id= '';
	for (i = 0;i < input.length;i++)
		{
				if(input[i].checked == true)
					{
						if(input[i].name == 'select')
						{
							id += input[i].value;
							id += "|";
						}
					}
		}
		window.location = "admin.php?page=persian-world-edit&deleted="+id;
}

</script>

					</div>
			</div>
		</div>
	</div>
	

<?php
}

?>
