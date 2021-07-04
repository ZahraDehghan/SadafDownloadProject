<?php 
/*
 	برنامه نویس: امید میلانی فرد
*/
include("header.inc.php");
include("classes/Requests.class.php");
HTMLBegin();

if(isset($_REQUEST["Save"])) 
{
	if(isset($_REQUEST["Item_AboutDownload"]))
		$Item_AboutDownload=$_REQUEST["Item_AboutDownload"];
	if(isset($_REQUEST["Item_WhyDownload"]))
		$Item_WhyDownload=$_REQUEST["Item_WhyDownload"];
	if(isset($_REQUEST["Item_LinkDownload"]))
		$Item_LinkDownload=$_REQUEST["Item_LinkDownload"];
		
	$t = manage_requests::Add($_SESSION["UserID"],$Item_AboutDownload,$Item_WhyDownload,$Item_LinkDownload);
	#var_dump($t);	
	echo SharedClass::CreateMessageBox("اطلاعات ذخیره شد");
}


?>
<form method="post" id="f1" name="f1" >
<br><table width="90%" border="1" cellspacing="0" align="center">
<tr class="HeaderOfTable">
<td align="center">درخواست جدید</td>
</tr>
<tr>
<td>
<table width="100%" border="0">
<tr>
	<td width="1%" nowrap>
 شرح دانلود : 
	</td>
	<td nowrap>
	<input type="text" name="Item_AboutDownload" id="Item_UserID" maxlength="100" size="40">
	</td>
</tr>
<tr>
	<td width="1%" nowrap>
 دلیل نیاز : 
	</td>
	<td nowrap>
	<input type="text" name="Item_WhyDownload" id="Item_UserPassword" maxlength="100" size="40">
	</td>
</tr>
<tr>
	<td width="1%" nowrap>
 لینک دانلود : 
	</td>
	<td nowrap>
		<input type="text" name="Item_LinkDownload" id="Item_UserPassword" maxlength="100" size="40">
	</td>
</tr>
</table>
</td>
</tr>
<tr class="FooterOfTable">
<td align="center">
<input type="button" onclick="javascript: ValidateForm();" value="افزودن">

</td>
</tr>
</table>
<input type="hidden" name="Save" id="Save" value="1">
</form><script>
	<? echo $LoadDataJavascriptCode; ?>
	function ValidateForm()
	{
		document.f1.submit();
	}
</script>
</html>


