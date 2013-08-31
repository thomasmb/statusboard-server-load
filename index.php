<?php

require_once( 'config.php' );

new SBServerLoad;

class SBServerLoad{

	protected $db = false;

	function __construct(){
		
		global $servers;
		
		$this->_connect_to_db();
	
		if( array_key_exists( $_SERVER['REMOTE_ADDR'] , $servers ) && isset( $_POST['loadavg'] ) )
			$this->_record_data();
		else
			$this->display_data();
	}
	
	public function display_data(){
	
		global $servers;
		
		$data = new stdClass();
	
		$data->graph = new stdClass();
		$graph = &$data->graph;
		
		$graph->refreshEveryNSeconds = 60;
		$graph->type = 'line';
		$graph->title = CHART_TITLE;
		$graph->datasequences = array();
		
		$query = $this->db->prepare( "SELECT * FROM serverload WHERE timestamp > ( NOW() - INTERVAL ? MINUTE ) ORDER BY timestamp DESC" );
		$query->execute( array( DISPLAY_IN_MINUTES ) );
		
		$servers_logs = array();
		
		while( $row = $query->fetch( PDO::FETCH_OBJ ) ){
			if( !isset( $servers_logs[ $row->ip ] ) ){
				$servers_logs[ $row->ip ] = array();
				
				$graph->datasequences[] = array(
					'title' => $servers[ $row->ip ],
					'datapoints' => &$servers_logs[ $row->ip ]
				);	
			}
			
			$load = explode( " ", $row->datavalue, 2 );
			$load = $load[0] * 100;
			
			$servers_logs[ $row->ip ][] = array(
				'title' => date( 'G:i', strtotime( $row->timestamp ) ),
				'value' => $load
			);
		}
		
		echo json_encode( $data );
		
	}
	
	protected function _record_data(){	
		$data = array(
			'ip' => $_SERVER['REMOTE_ADDR'],
			'loadavg' => $_POST['loadavg']
		);
		
		$this->_insert_data( $data );
		$this->_cleanup();
	}
	
	protected function _insert_data( $data ){		
		$query = $this->db->prepare( "INSERT INTO serverload (ip, datakey, datavalue) VALUES (?,?,?)" );
		$query->execute( array( $data['ip'], 'loadavg', $data['loadavg'] ) );	
	}
	
	protected function _cleanup(){
		if( AUTO_CLEAN_UP ){
			$query = $this->db->prepare( "DELETE FROM serverload WHERE timestamp < ( NOW() - INTERVAL ? MINUTE )" );
			$query->execute( array( STORE_IN_MINUTES ) );
		}
	}
	
	protected function _connect_to_db(){
		try {
		    $this->db = new PDO( "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS, 
		    				array( PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'' ) );
		} catch (PDOException $e) {
		    echo 'Connection failed: ' . $e->getMessage();
		}
	}
}
