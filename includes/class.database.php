<?php

class Database {
	private $db;

	public function __construct($dbType,$dbHost,$dbName,$dbUser,$dbPass) {
		try {
			$this->db = new PDO("$dbType:host=$dbHost;dbname=$dbName",$dbUser	
								,$dbPass,array(
									PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
								));
		} catch( PDOException $pe ) {
			die( $pe->getMessage() );
		}
	}
	
	public function query($type,$sql,$param) {
		$res = array(
			'status' => false,
		);
		try {
			$stmt = $this->db->prepare($sql);
			if( !empty($param) ) {
				foreach($param as $k=>$v) {
					$stmt->bindValue($k,$v);
				}
			}	
			$stmt->execute();
			$res['status'] = true;
			$res['data'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$res['count'] = count($res['data']);
		} catch( PDOException $e ) {
			$res['error'] = $e->getMessage();
		} finally {
			return $res;
		}
	}
}
?>