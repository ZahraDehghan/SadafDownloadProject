<?php 
/*
	برنامه نویس: امید میلانی فرد
*/
if(!isset($_GET['get_list']))
{
include("header.inc.php");
include("classes/Requests.class.php");
HTMLBegin();

if(isset($_REQUEST["Save"])) 
{
	if(isset($_REQUEST["Item_status"]))
		$Item_status=$_REQUEST["Item_status"];
	if(isset($_REQUEST["Item_PageAddress"]))
		$Item_PageAddress=$_REQUEST["Item_PageAddress"];
	if($_REQUEST['UpdateID']!='0')
	{
		manage_requests::update_download_loc($Item_status,$Item_PageAddress,$_REQUEST['UpdateID']);
	}
	echo SharedClass::CreateMessageBox("اطلاعات ذخیره شد");
}
?>
<form method="post" id="f1" name="f1" >
<input type="hidden" name="UpdateID" id="UpdateID" value='0'>
<div class="container-fluid">

<? BootStrapModal("UserListDiv", "UserListDivHeader", "UserListDivContent", "کاربران"); ?>

<div class="modal fade" id="DataEntryForm" tabindex="-1" role="dialog" aria-labelledby="..." aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header align-right DivRtl">
        <h5 class="modal-title" id="exampleModalLongTitle">ویرایش 	درخواست </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
			<div class="row">
			<div class="col">
				<table class="table table-sm table-stripped table-bordered">
			
				<tr>
					<td width="1%" nowrap>
				 وضیعت
					</td>
					<td nowrap>
					<select class="form-control sadaf-m-input" name="Item_status" id="Item_status">
						<option value="رد شده">رد شده</option>
						<option value="دانلود غیر خودکار">دانلود غیر خودکار</option>
						<option value="دریافت شده">دریافت شده</option>
					</select>
					</td>
				</tr>
				
				<tr>
					<td width="1%" nowrap>
				 ثبت مسیر دانلود 
					</td>
					<td nowrap>
					<input type="text" dir="ltr" class="form-control sadaf-m-input" name="Item_PageAddress" id="Item_PageAddress" maxlength="345" size="40">
					</td>
				</tr>
				</table>
			</div>
			</div>
      </div>
      <div class="modal-footer DivRtl">
		<button type="button" class="btn btn-primary" onclick='javascript: ValidateForm();'>ذخیره</button>
      </div>
    </div>
  </div>
</div>

<input type="hidden" name="Save" id="Save" value="1">
</form><script>
	function ValidateForm()
	{
		document.f1.submit();
	}
</script>
<?php 

$res = manage_requests::GetListatomatic(); 
?>
<br>
		<div class="portlet box green">
		<div class="portlet-title">
	
			<div class="caption font-dark">
			<i class="material-icons">settings</i>
				دریافت های خودکار
			</div>
		</div>
		<div class="portlet-body">
			<form id="ListForm" name="ListForm" method="post"> 
			<table id="FacilityListTable" class="table ">
			<thead>

				<th>درخواست </th>
				<th>زمان شروع</th>
				<th>توضیحات</th>		
				<th>لینک</th>		
				<th>عملیات</th>				
			</thead>
			<tbody>
			<?
			for($k=0; $k<count($res); $k++)
			{
				echo "<tr>";

				echo "	<td>".$res[$k]['discription']."</td>";
				echo "	<td>".manage_requests::g2j($res[$k]['start_time'])."</td>";
				echo "	<td>".$res[$k]['why']."</td>";		
				echo "	<td><a href=\"".$res[$k]['link']."\"><i class='material-icons' data-toggle=\"tooltip\" data-placement=\"top\" title=\"لینک\" >link</i></a></td>";		
				echo "<td>";
				echo "<a href=\"javascript: SetRecordForUpdate(".$res[$k]['download_id'].");\" >";
				echo "<i class='material-icons' data-toggle=\"tooltip\" data-placement=\"top\" title=\"ویرایش\" >edit</i>";
				echo "</a>";
				echo "</td>";
				echo "</tr>";
			}
			?>
			</tbody>
			</table>
		</div>
	</div>
</form>
<form target="_blank" method="post" action="NewSystemFacilities.php" id="NewRecordForm" name="NewRecordForm">
</form>
<? HTMLEnd(); ?>
<script>
	$(document).ready(function() {
	
    var MyDataTable = $('#FacilityListTable').DataTable( {
	stateSave: true, 
	"order": [[ 1, "desc" ]],
	"pagingType": "numbers",
	"decimal":        "",
	"language": {
    "emptyTable":     "رکوردی وجود ندارد",
    "info":           "نمایش ردیف _START_ تا _END_ از _TOTAL_ رکورد",
    "infoEmpty":      "",
    "infoFiltered":   "(فیلتر شده از بین _MAX_ ورودی)",
    "infoPostFix":    "",
    "thousands":      ",",
    "lengthMenu":     "نمایش _MENU_ رکورد در هر صفحه",
    "loadingRecords": "در حال بارگذاری...",
    "processing":     "در حال پردازش...",
    "search":         "جستجو: ",
    "zeroRecords":    "رکوردی یافت نشد"
	},
	"dom": '<"DivRtl" l><"DivRtl" f>t<"DivRtl" ip>',
	"columns": [
    null,
	null,
    null,
    { "orderable": false },
    { "orderable": false }
	]
	
    } );

	MyDataTable.draw();
} );

function ShowUsersList(uid)
{
	ShowDetailsInModal("ManageUserFacilities.php", "#UserListDiv", "کاربران", "UserListDivContent", "UserListDivHeader", "FacilityID", uid);
}


function readJSON() {
    var request = new XMLHttpRequest();
    request.open('GET', 'AutomaticRequests.php?get_list', false);
    request.send(null);
}


$(function () {
		readJSON();
	 setInterval(readJSON, 60000);
  $('[data-toggle="tooltip"]').tooltip()
})

$('[data-toggle=confirmation]').confirmation({
  rootSelector: '[data-toggle=confirmation]',
  onConfirm: function(value) {
    document.ListForm.submit();
  }  
});


function SetRecordForUpdate(uid)
{
	document.getElementById("UpdateID").value = uid;

	$('#DataEntryForm').modal();

}

</script>
</html>
<?php 
}
else{
  session_start();
  function downloadFile($url)
  {
		file_put_contents('uploads/'.basename($url), fopen($url, 'r'));
		return 'uploads/'.basename($url);
  }
  if(isset($_SESSION['UserID'])){
    include "../shares/sys_config.class.php";
    include "../shares/DateUtils.inc.php";
    include "../shares/SharedClass.class.php";
    include("classes/Requests.class.php");
    $res = manage_requests::GetDownloadList();
    $x = array();
    for($i =0;$i<count($res);$i++){
      array_push($x,$res[$i]['link']);
      $resfile = downloadFile($res[$i]['link']);
      manage_requests::update_download_loc("دریافت شده", $resfile, $res[$i]['download_id']);
    }
    // print(json_encode($x));
  }  
}

?>