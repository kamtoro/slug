<?php

class crud
{
	private $db;
	
	function __construct($DB_con){
		echo "Aca entro...1";
		$this->db = $DB_con;
	}
	
	//Functions to return list of Data
	public function getArrayList($queryStr) {//DataList
		$stmt = $this->db->prepare($queryStr);
	 	$stmt->execute();
		$dataList=$stmt->fetch(PDO::FETCH_ASSOC);
		return $dataList;
	}

	public function getSourceList() {//DataList
		$sourceSql  = "SELECT DISTINCT source FROM sourceList ORDER BY source asc";
		return getArrayList($sourceSql);
	}
	public function getLocationList() {//DataList
		$locationSql= "SELECT DISTINCT location FROM locationList ORDER BY location asc";
		return getArrayList($locationSql);
	}
	public function getPersonList() {//DataList
		$personSql  = "SELECT DISTINCT lastname FROM personList ORDER BY lastname asc";
		return getArrayList($personSql);
	}
	public function getTitleList() {//DataList
		$titleSql   = "SELECT DISTINCT title FROM titleList ORDER BY title asc";
		return getArrayList($titleSql);
	}

	// public function create($fname,$lname,$email,$contact)
	// {
	// 	try
	// 	{
	// 		$stmt = $this->db->prepare("INSERT INTO personList(first_name,last_name,email_id,contact_no) VALUES(:fname, :lname, :email, :contact)");
	// 		$stmt->bindparam(":fname",$fname);
	// 		$stmt->bindparam(":lname",$lname);
	// 		$stmt->bindparam(":email",$email);
	// 		$stmt->bindparam(":contact",$contact);
	// 		$stmt->execute();
	// 		return true;
	// 	}
	// 	catch(PDOException $e)
	// 	{
	// 		echo $e->getMessage();	
	// 		return false;
	// 	}
		
	// }
	
	// public function getID($id)
	// {
	// 	$stmt = $this->db->prepare("SELECT * FROM tbl_users WHERE id=:id");
	// 	$stmt->execute(array(":id"=>$id));
	// 	$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
	// 	return $editRow;
	// }
	
	// public function update($id,$fname,$lname,$email,$contact)
	// {
	// 	try
	// 	{
	// 		$stmt=$this->db->prepare("UPDATE tbl_users SET first_name=:fname, 
	// 	                                               last_name=:lname, 
	// 												   email_id=:email, 
	// 												   contact_no=:contact
	// 												WHERE id=:id ");
	// 		$stmt->bindparam(":fname",$fname);
	// 		$stmt->bindparam(":lname",$lname);
	// 		$stmt->bindparam(":email",$email);
	// 		$stmt->bindparam(":contact",$contact);
	// 		$stmt->bindparam(":id",$id);
	// 		$stmt->execute();
			
	// 		return true;	
	// 	}
	// 	catch(PDOException $e)
	// 	{
	// 		echo $e->getMessage();	
	// 		return false;
	// 	}
	// }
	
	// public function delete($id)
	// {
	// 	$stmt = $this->db->prepare("DELETE FROM personList WHERE id=:id");
	// 	$stmt->bindparam(":id",$id);
	// 	$stmt->execute();
	// 	return true;
	// }
	
	/* paging */
	
	// public function dataview($query)
	// {
	// 	$stmt = $this->db->prepare($query);
	// 	$stmt->execute();
	
	// 	if($stmt->rowCount()>0)
	// 	{
	// 		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
	// 		{

	// 	}
		
	// }
	
	// public function paging($query,$records_per_page)
	// {
	// 	$starting_position=0;
	// 	if(isset($_GET["page_no"]))
	// 	{
	// 		$starting_position=($_GET["page_no"]-1)*$records_per_page;
	// 	}
	// 	$query2=$query." limit $starting_position,$records_per_page";
	// 	return $query2;
	// }
	
	// public function paginglink($query,$records_per_page)
	// {
		
	// 	$self = $_SERVER['PHP_SELF'];
		
	// 	$stmt = $this->db->prepare($query);
	// 	$stmt->execute();
		
	// 	$total_no_of_records = $stmt->rowCount();
		
	// 	if($total_no_of_records > 0)
	// 	{
	// 		? ><ul class="pagination"><?php
	// 		$total_no_of_pages=ceil($total_no_of_records/$records_per_page);
	// 		$current_page=1;
	// 		if(isset($_GET["page_no"]))
	// 		{
	// 			$current_page=$_GET["page_no"];
	// 		}
	// 		if($current_page!=1)
	// 		{
	// 			$previous =$current_page-1;
	// 			echo "<li><a href='".$self."?page_no=1'>First</a></li>";
	// 			echo "<li><a href='".$self."?page_no=".$previous."'>Previous</a></li>";
	// 		}
	// 		for($i=1;$i<=$total_no_of_pages;$i++)
	// 		{
	// 			if($i==$current_page)
	// 			{
	// 				echo "<li><a href='".$self."?page_no=".$i."' style='color:red;'>".$i."</a></li>";
	// 			}
	// 			else
	// 			{
	// 				echo "<li><a href='".$self."?page_no=".$i."'>".$i."</a></li>";
	// 			}
	// 		}
	// 		if($current_page!=$total_no_of_pages)
	// 		{
	// 			$next=$current_page+1;
	// 			echo "<li><a href='".$self."?page_no=".$next."'>Next</a></li>";
	// 			echo "<li><a href='".$self."?page_no=".$total_no_of_pages."'>Last</a></li>";
	// 		}
	// 		? ></ul><?php
	// 	}
	// }
	
	/* paging */
	
}
