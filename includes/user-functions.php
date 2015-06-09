<?php
	require 'main-functions.php';
	
	function usrRegister($fname,$lname,$uname,$pass,$bio) {
		global $db;
		
		$query = "INSERT INTO ava_member(firstName,lastName,username,password,bio) 
					VALUES(:firstName,:lastName,:username,:password,:bio)";
		$htmlBio = "";
		for( $i = 0; $i < strlen($bio); $i++ ) {
			$c = substr($bio,$i,1);
			$htmlBio .= ( $c === "\n" ? "<br />" : ($c === "\r" ? "" : $c ));
		}
		$param = array(
			':firstName' => $fname,
			':lastName' => $lname,
			':username' => $uname,
			':password' => hash("md5","Arthur".$pass."Guinevere"),
			':bio' => $htmlBio	
		);
		$res = $db->query("INSERT",$query,$param);
		
		return $res['status'];
	}
	
	function usrGetData($uname) {
		global $db;
		
		$query = "SELECT password, moder, admin
					FROM ava_member
					WHERE username = :username AND status = 1";
		$param = array(
			':username' => $uname	
		);
		$res = $db->query("SELECT",$query,$param);
		if( $res['status'] ) {
			if( $res['count'] > 0 ) {
				return $res['data'][0];
			} else {
				return false;
			}
		} else {
			return null;
		}	
	}
	
	function usrCheckUsername($uname) {
		global $db;
	
		//check if username is in the database
		$query = "SELECT username FROM ava_member WHERE username = :username";
		$param = array(
			":username" => $uname
		);
		$res = $db->query("SELECT",$query,$param);
		//return if exists
		return ( $res['count'] > 0 ? "true" : "false" );
	}
	
	function usrGetId($uname) {
		global $db;
	
		$query = "SELECT id FROM ava_member WHERE username = :username";
		$param = array(
			':username' => $uname	
		);
		$res = $db->query("SELECT",$query,$param);
		if( $res['status'] ) {
			if( $res['count'] > 0 ) {
				return $res['data'][0]['id']; 
			} else {
				return false;
			}
		} else {
			return null;
		}
	}
?>