<?php
include "jdf.php";
class manage_requests
{
	static function Add($UserID,$discription,$why,$link){
		$mysql = pdodb::getInstance();
		$query = "insert into sadaf.download (";
		$query .= " UserID";
		$query .= ", discription";
		$query .= ", why";
		$query .= ", link";
		$query .= ", status_name";
		$query .= ") values (";
		$query .= "? , ? , ? , ? , ? ";
		$query .= ")";
		$ValueListArray = array();
		array_push($ValueListArray, $UserID); 
		array_push($ValueListArray, $discription); 
		array_push($ValueListArray, $why); 
		array_push($ValueListArray, $link);
		array_push($ValueListArray, "درخواست اولیه");
		$mysql->Prepare($query);
		$mysql->ExecuteStatement($ValueListArray);	
		#return $mysql->fetchall();
	}
	static function GetList(){
		$mysql = pdodb::getInstance();
		$k=0;
		$ret = array();
		$query = "select * from sadaf.download  ";
		$res = $mysql->Execute($query);
		$i=0;
		
		return $res->fetchall();
	}
	static function GetListUNseen(){
		$mysql = pdodb::getInstance();
		$query = "select * from sadaf.download  where `status_name`=\"درخواست اولیه\"";
		$res = $mysql->Execute($query);
		return $res->fetchall();
	}
	static function GetListUNatomatic(){
		$mysql = pdodb::getInstance();
		$query = "select * from sadaf.download  where `status_name`=\"دانلود غیر خودکار\"";
		$res = $mysql->Execute($query);
		return $res->fetchall();
	}
	static function GetListatomatic(){
		$mysql = pdodb::getInstance();
		$query = "select * from sadaf.download  where `status_name`=\"زمانبندی دانلود\"";
		$res = $mysql->Execute($query);
		return $res->fetchall();
	}
	static function GetDownloadList(){
		$mysql = pdodb::getInstance();
		$query = "select * from sadaf.download  where NOW()>`start_time` AND `status_name`=\"زمانبندی دانلود\"";
		$res = $mysql->Execute($query);
		return $res->fetchall();
	}
	static function GetListDone(){
		$mysql = pdodb::getInstance();
		$query = "select * from sadaf.download  where `status_name`!=\"درخواست اولیه\"";
		$res = $mysql->Execute($query);
		return $res->fetchall();
	}
	static function update_download($status_name,$start_time,$id){
		$mysql = pdodb::getInstance();
		$query = "UPDATE sadaf.download SET `status_name`=?,`start_time`=? where `download_id`=? ";
		$mysql->Prepare($query);
		$mysql->ExecuteStatement(array($status_name,$start_time,$id));
	}
	static function update_download_loc($status_name,$download_loc,$id){
		$mysql = pdodb::getInstance();
		$query = "UPDATE sadaf.download SET `status_name`=?,`download_loc`=? where `download_id`=? ";
		$mysql->Prepare($query);
		$mysql->ExecuteStatement(array($status_name,$download_loc,$id));
	}
	static function update_download2($status_name,$id){
		$mysql = pdodb::getInstance();
		$query = "UPDATE sadaf.download SET `status_name`=?,`download_loc`=? where `download_id`=? ";
		$mysql->Prepare($query);
		$mysql->ExecuteStatement(array($status_name,$id));
	}
	static function Delete($id){
		$mysql = pdodb::getInstance();
		$query = "delete from sadaf.download where `download_id`=?";
		$mysql->Prepare($query);
		$mysql->ExecuteStatement(array($id));
	}
	static function g2j($date)
	{
		$times=explode(' ', $date);
		$dates = explode('-', $times[0]);
		$year = $dates[0];
		$mounth = $dates[1];
		$day = $dates[2];
		$gdate= gregorian_to_jalali($year ,$mounth ,$day ,'/');
		$times[1] = explode(':',$times[1]);
		return $gdate.' '.$times[1][0].':'.$times[1][1];
	}
	static function j2g($date)
	{
		$times=explode(' ', $date);
		$dates = explode('/', $times[0]);
		$year = $dates[0];
		$mounth = $dates[1];
		$day = $dates[2];
		$gdate= jalali_to_gregorian($year ,$mounth ,$day ,'-');
		return $gdate.' '.$times[1];
	}
}

?>