<?php 
/*
	برنامه نویس: امید میلانی فرد
*/
include("header.inc.php");
include("classes/Requests.class.php");

HTMLBegin();
if(isset($_REQUEST["Save"])) 
{
	if($_REQUEST['UpdateID']!='0')
	{
		if(isset($_REQUEST["Item_status"]))
			$Item_status=$_REQUEST["Item_status"];
		if(isset($_REQUEST["UpdateID"]))
			$UpdateID=$_REQUEST["UpdateID"];
		if(isset($_REQUEST["Item_Time"])){
			if($_REQUEST["Item_Time"] == ""){
				manage_requests::update_download2($Item_status,$UpdateID);
			}
			else{
				manage_requests::update_download($Item_status,manage_requests::j2g($_REQUEST["Item_Time"]),$UpdateID);
			}		
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
						<option value="درخواست اولیه">درخواست اولیه</option>
						<option value="تایید کارشناس">تایید کارشناس</option>
						<option value="رد شده">رد شده</option>
						<option value="زمانبندی دانلود">زمانبندی دانلود</option>
						<option value="دانلود غیر خودکار">دانلود غیر خودکار</option>
						<option value="دریافت شده">دریافت شده</option>
					</select>
					</td>
				</tr>
				<tr>
					<td width="1%" nowrap>
				 زمان دانلود
					</td>
					<td nowrap>
					<input type="text" style="direction:ltr" placeholder="1400/01/01 00:00" class="form-control sadaf-m-input" name="Item_Time" id="Item_Time" maxlength="100" >
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

$res = manage_requests::GetListUNseen(); 
?>
<br>
		<div class="portlet box green">
		<div class="portlet-title">
	
			<div class="caption font-dark">
			<i class="material-icons">settings</i>
				درخواست های رسیدگی نشده
			</div>
		</div>
		<div class="portlet-body">
			<form id="ListForm" name="ListForm" method="post"> 
			<table id="FacilityListTable" class="table ">
			<thead>

				<th>درخواست </th>
				<th>وضیعت</th>
				<th>لینک</th>
				<th>توضیحات</th>
				<th>عملیات</th>				
			</thead>
			<tbody>
			<?
			for($k=0; $k<count($res); $k++)
			{
				echo "<tr>";

				echo "	<td>".$res[$k]['discription']."</td>";
				echo "	<td>".$res[$k]['status_name']."</td>";
				echo "  <td><a href=\"".$res[$k]['link']."\" target=\"_blank\">".$res[$k]['link']."</a></td>";
				echo "	<td>".$res[$k]['why']."</td>";		
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
    null, null, null,

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
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {			
			$('#DataEntryForm').modal();
		}
	};
	xmlhttp.open("GET", "ManageSystemFacilities.php?GetID="+uid, true);
	xmlhttp.send(); 
}

</script>
</html>
