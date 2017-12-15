<?php
class SpecialMetaNetLM extends SpecialPage {
	private $DBServer = "localhost";
	private $DBUser = "mnreadonly_user";
	private $DBPass = "mnreadme";
	private $DBName = "metanetlm";
	private $conn = NULL;
	
    function __construct() {
        parent::__construct( 'MetaNetLM' );
        $this->conn = new mysqli($this->DBServer, $this->DBUser, $this->DBPass, $this->DBName);
        // check connection
        if ($this->conn->connect_error) {
        	trigger_error('Database connection failed: '  . $this->conn->connect_error, E_USER_ERROR);
        }
    }
 
    function __destruct() {
    	#parent::__destruct( 'MetaNetLM');
    	$this->conn->close();
    	
    }
    function getAllLMs() {
    	$sql = 'SELECT id, name, nickname, targetlemma, sourcelemma, '.
    		'targetschema, sourceschema, targetconcept, sourceconcept, cxn, cm, lang '.
    		'FROM LM WHERE lang="en" AND cxn IS NOT NULL ORDER BY nickname ASC LIMIT 100';
    	$rs = $this->conn->query($sql);
    	if ($rs === false) {
    		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $this->conn->error, E_USER_ERROR);
    	} else {
    		$rows_returned = $rs->num_rows;
    	}
    	$rs->data_seek(0);
    	$rstr = "<table class=\"wikitable\">\n";
    	$rstr .= '<tr>';
    	$rstr .= '<th>LM</th>';
    	$rstr .= '<th>Target Lemma</th>';
    	$rstr .= '<th>Target Schema</th>';
    	$rstr .= '<th>Target Concept</th>';
    	$rstr .= '<th>Source Lemma</th>';
    	$rstr .= '<th>Source Schema</th>';
    	$rstr .= '<th>Source Concept</th>';
    	$rstr .= "<tr>\n";
    	while($row = $rs->fetch_assoc()){
    		$rstr .= '<tr>';
    		$rstr .= '<td>' . $row['nickname'] . '</td>';
    		$rstr .= '<td>' . $row['targetlemma'] . '</td>';
    		$rstr .= '<td>' . $row['targetschema'] . '</td>';
    		$rstr .= '<td>' . $row['targetconcept'] . '</td>';
    		$rstr .= '<td>' . $row['sourcelemma'] . '</td>';
    		$rstr .= '<td>' . $row['sourceschema'] . '</td>';
    		$rstr .= '<td>' . $row['sourceconcept'] . '</td>';
    		$rstr .= "</tr>\n";
    	}
    	$rstr .= "</table>\n";
    	$rs->free();
    	return $rstr;
    }
    
    function execute( $par ) {
        $request = $this->getRequest();
        $output = $this->getOutput();
        $this->setHeaders();
 
        # Get request data from, e.g.
        $param = $request->getText( 'param' );

        # par will contain the ID number of an LM?
 
        # Do stuff
        # ...
        $output->addWikiText( "==All LMs==" );
        $output->addHTML($this->getAllLMs());
    }
}
