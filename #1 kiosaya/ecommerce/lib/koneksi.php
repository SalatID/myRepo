<?php
class database {
	var $host="192.168.43.33";
	var $user="kiosaya";
	var $pass="kiosaya";
	var $db="kiosaya";

	function __construct(){
		$koneksi= mysql_connect($this->host, $this->user, $this->pass) or die (mysql_error());
		mysql_select_db($this->db);

	}
	function input($nama, $alamat, $provinsi, $kota, $telepon, $email, $password, $retype){
		mysql_query("insert into user values('','$nama', '$alamat','$provinsi', '$kota', '$telepon', '$email', '$password', '$retype')");
	}
	function tampil(){
		$data=mysql_query("select * from provinces order by name");
		while ($d=mysql_fetch_array($data)){
			$hasil[]=$d;
		}
		return $hasil;
	}

}
?>
