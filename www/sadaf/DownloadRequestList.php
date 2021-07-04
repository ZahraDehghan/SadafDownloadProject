<?php 
/*
	برنامه نویس: امید میلانی فرد
*/
include("header.inc.php");
include("classes/Requests.class.php");

include "PAS_shared_utils.php";


HTMLBegin();
if(isset($_REQUEST["Save"])) 
{
	if(isset($_REQUEST['UpdateID'])){
		if($_REQUEST['UpdateID']!=0){
			manage_requests::Delete($_REQUEST['UpdateID']);
		}
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
        <h5 class="modal-title" id="exampleModalLongTitle">لغو درخواست</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

			<p style="direction:rtl">آیا از لغو این درخواست اطمینان دارید ؟</p>

      </div>
      <div class="modal-footer DivRtl">
		<button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close" >خیر</button>
		<button type="button" class="btn btn-danger" onclick='javascript: ValidateForm();'>بله</button>
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

$res = manage_requests::GetList(); 

?>
<br>
		<div class="portlet box green">
		<div class="portlet-title">
	
			<div class="caption font-dark">
			<i class="material-icons">settings</i>
			فهرست درخواست ها
			</div>
		</div>
		<div class="portlet-body">
			<form id="ListForm" name="ListForm" method="post"> 
			<table id="FacilityListTable" class="table ">
			<thead>
				<th>درخواست </th>
				<th>وضیعت</th>
				<th>زمان شروع</th>
				<th>لینک</th>		
				<th>توضیحات</th>				
				<th>لغو درخواست</th>				
			</thead>
			<tbody>
			<?
			for($k=0; $k<count($res); $k++)
			{
				echo "<tr>";
				echo "	<td>".$res[$k]['discription']."</td>";
				echo "	<td>".$res[$k]['status_name']."</td>";
				echo "	<td>".($res[$k]['start_time']==null ? "نامشخص" : manage_requests::g2j($res[$k]['start_time']))."</td>";
				echo "<td>";
				echo "<a href=\"".($res[$k]['status_name']=='دریافت شده' ? ''.$res[$k]['download_loc']:$res[$k]['link']) ."\" target=\"_blank\"><i class='material-icons' data-toggle=\"tooltip\" data-placement=\"top\" title=\"لینک\" >link</i></a>";
				echo "</td>";
				echo "<td>";
				echo "<i class='material-icons' data-toggle=\"tooltip\" data-placement=\"top\" title=\"".$res[$k]['why']."\" >info</i>";
				echo "</td>";
				echo "<td>";
				echo "<a href=\"javascript: SetRecordForUpdate(".$res[$k]['download_id'].");\" >";
				echo "<i class='material-icons' data-toggle=\"tooltip\" data-placement=\"top\" title=\"لغو این درخواست\" >cancel</i>";
				echo "</a>";
				echo "</td>";
				echo "</tr>";
			}
			?>
			</tbody>
			</table>
			<a href="NewDownloadRequest.php">
			<i class='material-icons' data-toggle="tooltip" data-placement="top" title="افزودن" >add</i>
			</a>
		</div>
	</div>
</form>
<form target="_blank" method="post" action="NewSystemFacilities.php" id="NewRecordForm" name="NewRecordForm">
</form>
<? HTMLEnd(); ?>
<script>

function ShowUsersList(uid)
{
	ShowDetailsInModal("ManageUserFacilities.php", "#UserListDiv", "کاربران", "UserListDivContent", "UserListDivHeader", "FacilityID", uid);
}

function RemoveUser(uid, item_id)
{
	DoActionAndRefreshModal("ManageUserFacilities.php", "#UserListDiv", "", "UserListDivContent", "UserListDivHeader", "FacilityID", uid, "RemoveItemID", item_id);
}

function AddUser(uid)
{
	DoActionAndRefreshModal("ManageUserFacilities.php", "#UserListDiv", "", "UserListDivContent", "UserListDivHeader", "FacilityID", uid, "Item_UserID", document.getElementById('Item_UserID').value);
}

$(document).ready(function() {
	
    var MyDataTable = $('#FacilityListTable').DataTable( {
	stateSave: true, 
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
    { "orderable": false },
    { "orderable": false }
	]
	
    } );

	MyDataTable.draw();
} );

$(function () {
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
