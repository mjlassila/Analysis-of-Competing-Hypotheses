<?php
/* ////////////////////////////////////////////////////////////////////////////////
**    Copyright 2010 Matthew Burton, http://matthewburton.org
**    Code by Burton and Joshua Knowles, http://auscillate.com 
**
**    This software is part of the Open Source ACH Project (ACH). You'll find 
**    all current information about project contributors, installation, updates, 
**    bugs and more at http://competinghypotheses.org.
**
**
**    ACH is free software: you can redistribute it and/or modify
**    it under the terms of the GNU General Public License as published by
**    the Free Software Foundation, either version 3 of the License, or
**    (at your option) any later version.
**
**    ACH is distributed in the hope that it will be useful,
**    but WITHOUT ANY WARRANTY; without even the implied warranty of
**    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
**    GNU General Public License for more details.
**
**    You should have received a copy of the GNU General Public License
**    along with Open Source ACH. If not, see <http://www.gnu.org/licenses/>.
//////////////////////////////////////////////////////////////////////////////// */

include (__DIR__."/../LocalSettings.php");

$SQL_CACHING_ACTIVE = TRUE; // Set this to FALSE to turn off SQL caching.
$SPEED_REPORTING = TRUE; // Set this to FALSE to turn off the speed display at the bottom of the pages.

$DB_QUERIES = 0; // Total number of times the database is accessed.

$SQL_STATEMENTS_ALL = array();
$SQL_STATEMENTS_CACHE = array();
$SQL_CACHE = array();
$SQL_DUPES = 0;
$SQL_SELECTS = 0;

$MYSQL_ERRNO = '';

function achconnect() {
	global $dbhost, $dbusername, $dbuserpassword, $dbname, $default_dbname;
	global $MYSQL_ERRNO, $MYSQL_ERROR;
	global $DB_QUERIES;
	
	$DB_QUERIES++;
	
	if(empty($dbhost)){ $dbhost = 'localhost'; }
	if(empty($dbusername)){ $dbusername = 'root'; }
	if(empty($dbname)){ $dbname = 'ach'; }

	$mysqli = new mysqli($dbhost, $dbusername, $dbuserpassword, $dbname);
	
	if ($mysqli->connect_errno) {
    	echo("Failed to connect to Database: ".$mysqli->connect_error);
    	exit();
	}	
	else return $mysqli;
}

function sql_error() {
	global $MYSQL_ERRNO, $MYSQL_ERROR;
	
	if(empty($MYSQL_ERROR)) {
		$MYSQL_ERRNO = mysql_errno();
		$MYSQL_ERROR = mysql_error();
	}
	return "$MYSQL_ERRNO: $MYSQL_ERROR";
}

function achquery($sql) {
	global $SQL_SELECTS, $SQL_STATEMENTS_ALL;
	
	$SQL_STATEMENTS_ALL[] = $sql;

	if( strtolower(substr($sql, 0, 6)) == "select" ) {
		$SQL_SELECTS++;
	}

	$link = achconnect();
	$result = $link->query($sql);
	
	return $result;
}

#TODO: Should Refactor/Remove this...
function mysql_fast($sql) {
	// Cached SQL statements, DOESN'T RESULT RESULT RESOURCE, RETURNS $query_data ARRAY. 
	//  FOR NOW, limit to QUERIES WITH ONE RESULT.
	global $SQL_CACHING_ACTIVE, $SQL_STATEMENTS_CACHE, $SQL_DUPES, $SQL_CACHE;
	$results = array();

	if( $SQL_CACHING_ACTIVE && strtolower(substr($sql, 0, 6)) == "select" ) {
		if( in_array($sql, $SQL_STATEMENTS_CACHE) ) {
			$SQL_DUPES++;
			$results = $SQL_CACHE[$sql];
		} else {
			$result = achquery($sql);
			while( $query_data = mysqli_fetch_array($result) ) {
				$results[] = $query_data;
			}
			$SQL_CACHE[$sql] = $results;
			$SQL_STATEMENTS_CACHE[] = $sql;
		}
	} else {
		$result = achquery($sql);
		while( $query_data = mysql_fetch_array($result) ) {
			$results[] = $query_data;
		}
	}	
	//echo("<i>" . $sql . "</i><br />");
	return $results;
}

function getFieldList($table) {
        
        $fldlist = achquery("SHOW COLUMNS FROM ".$table);				
        
        while (($field = mysqli_fetch_row($fldlist)) !== NULL ){
        	$listing[] = $field[0];
        }
		
        return($listing);
}
