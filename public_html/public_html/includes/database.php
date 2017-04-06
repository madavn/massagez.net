<?php
//include INCLUDES."config.php";

class MySQLDatabase {
	
	private $connection;
	public $last_query;
	private $magic_quotes_active;
	private $real_escape_string_exists;
	public $result;
	
  function __construct() {
    $this->open_connection();
		$this->magic_quotes_active = get_magic_quotes_gpc();
		$this->real_escape_string_exists = function_exists( "mysql_real_escape_string" );
  }

	public function open_connection() {
		$this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
		if (!$this->connection) {
			die("Database connection failed: " . mysql_error());
		} else {
			$db_select = mysql_select_db(DB_NAME, $this->connection);
			if (!$db_select) {
				die("Database selection failed: " . mysql_error());
			}
		}
	}
	
	public function close_connection() {
		if(isset($this->connection)) {
			mysql_close($this->connection);
			unset($this->connection);
		}
	}

	public function query($sql) {
		$this->last_query = $sql;
		$this->result = mysql_query($sql, $this->connection);
		$this->confirm_query($this->result);
		return $this->result;
	}
	
	public function escape_value( $value ) {
		if( $this->real_escape_string_exists ) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			if( $this->magic_quotes_active ) { $value = stripslashes( $value ); }
			$value = mysql_real_escape_string( $value );
		} else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			if( !$this->magic_quotes_active ) { $value = addslashes( $value ); }
			// if magic quotes are active, then the slashes already exist
		}
		return $value;
	}
	
	// Phương thức lấy dữ liệu thông thường
  public function fetch_array($result_set) {
    return mysql_fetch_assoc($result_set);
    //return mysql_fetch_array($result_set);
  }
  
  public function num_rows($result_set) {
   return mysql_num_rows($result_set);
  }
  
  public function insert_id() {
    // lấy giá trị id được cập nhật sau cùng
    return mysql_insert_id($this->connection);
  }
  
  public function affected_rows() {
    return mysql_affected_rows($this->connection);
  }

	public function confirm_query($result) {
		if (!$result) {
	    $output = "Database query failed: " . mysql_error() . "<br /><br />";
	    $output .= "Last SQL query: " . $this->last_query;
	    //die( $output );
        return $output;
		}
	}
    
    public function insert($table, $arr) {
        $columns_arr = array_keys($arr);
        $value = array_values($arr);
        //$columns_str = implode(",", $columns_arr);
        $sql = "insert into $table (".join(",",$columns_arr).") values('". join("','", $value)."')";
        //$preparedStatement = $this->prepare($sql);
        //$preparedStatement->execute(array_combine($key, $value));
        $this->query($sql);
    }

    public function delete($table, $where = "") {
        $sql = "delete from $table ";
        if ($where != '')
            $sql .= "where $where";
        $this->query($sql);
    }

    public function update($table, $column, $where) {
        $sql = "update $table set ";
        //$keyend = end(array_keys($column));
        $a = array();
        foreach ($column as $key => $value) {
            $a[] = "$key = '$value' ";
            //if ($key != $keyend)
                //$sql .= ", ";
        }
        $sql .= join(",",$a);
        $sql .= " where $where";
        //echo $sql.'<br />';
        $this->query($sql);
    }
    
    public function update_self($table, $column, $where) {
        $sql = "update $table set ";
        //$keyend = end(array_keys($column));
        $a = array();
        foreach ($column as $key => $value) {
            $a[] = "$key = $value ";
            //if ($key != $keyend)
                //$sql .= ", ";
        }
        $sql .= join(",",$a);
        $sql .= " where $where";
        //echo $sql.'<br />';
        $this->query($sql);
    }
}
$database = new MySQLDatabase();
$db =& $database;
?>