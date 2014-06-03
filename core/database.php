<?php
if (!defined('HOST')) exit('Access Denied');

/**
 * The MySQL Improved driver extends the Database_Library to provide
 * interaction with a MySQL database
 */
class Database
{
    
    /**
     * connect holds MySQLi resource
     */
    private $db;
    
    // * Query to perform
    private $query;
    
    //query holder
    private $result;
    
    // Result holds data retrieved from server
    private $num_rows;
    
    // store the nos of rows in a result
    
    public function __construct() 
    {
        $this->con();
    }
    
    function con() 
    {
        try
        {

            $this->db = new PDO(DT . ':host=' . HN . '; dbname=' . DN, UN, PW, array(
                PDO::ATTR_PERSISTENT => true
            ));

        }
        catch(PDOException $e) 
        {
            var_dump($e);

            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public function startMasterDB(){
        try
        {
            $db = new PDO(DT . ':host=' . HN . '; dbname=' . DN, UN2, PW2, array(
                PDO::ATTR_PERSISTENT => true
            ));

            return $db;
        }
        catch(PDOException $e) 
        {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }
    
    public function __sleep() 
    {
        return array(
            'mysql:host=' . HN . '; dbname=' . DN,
            UN,
            PW
        );
    }
    
    public function __wakeup() 
    {
        $this->con();
    }
    
    function connect() 
    {
        if ($this->db == null) 
        {
            $this->con();
        }
    }
    
    function disconnect() 
    {
        if ($this->db != null) 
        {
            $this->db = null;
        }
    }
    
    public function strip_html_tags($value) 
    {
        $value = preg_replace(array(
            
            // Remove invisible content
            '@<head[^>]*?>.*?</head>@siu',
            '@<style[^>]*?>.*?</style>@siu',
            '@<script[^>]*?.*?</script>@siu',
            '@<object[^>]*?.*?</object>@siu',
            '@<embed[^>]*?.*?</embed>@siu',
            '@<applet[^>]*?.*?</applet>@siu',
            '@<noframes[^>]*?.*?</noframes>@siu',
            '@<noscript[^>]*?.*?</noscript>@siu',
            '@<noembed[^>]*?.*?</noembed>@siu'
        ) , array(
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        ) , $value);
        
        return strip_tags($value);
    }
    public function fix_page($value) 
    {
        $value = htmlspecialchars(trim($value));
        if (get_magic_quotes_gpc()) $value = stripslashes($value);
        return $value;
    }
    
    public function fix_mysql($value) 
    {
        if (get_magic_quotes_gpc()) 
        {
            $value = stripslashes($value);
        }
        $value = $this->db->real_escape_string(trim($value));
        return $value;
    }
    
    public function clean($value) 
    {
        $value = $this->fix_page($value);
        $value = $this->strip_html_tags($value);
        $bad = array(
            "=",
            "<",
            ">",
            "/",
            "\"",
            "`",
            "~",
            "'",
            "$",
            "%",
            "#",
            "?",
            ".exe"
        );
        $value = str_replace($bad, "", $value);
        
        //$value = $this->fix_mysql($value);
        return $value;
    }
    
    //end of clean
    
    public function clean_input($value) 
    {
        $bad = array(
            "=",
            "<",
            ">",
            "/",
            "\"",
            "`",
            "~",
            "'",
            "$",
            "%",
            "#",
            "?",
            ".exe"
        );
        $value = str_replace($bad, "", $value);
        return $value;
    }
    
    //end of clean_input
    
    //fetch one rows in a result and store it as  array
    public function query($sql) 
    {
        if (!empty($sql)) 
        {
            $this->connect();
            
            //connect to database
            try
            {
                $q = $this->db->prepare($sql);
                $q->execute();
                $q->setFetchMode(PDO::FETCH_ASSOC);
                $data = $q->fetchAll();
                
                return $data;
                
                //echo json_encode($data);
                $this->disconnect();
                
                //disconnect from database
                
                
            }
            catch(PDOException $e) 
            {
                return $e->getMessage();
            }
        } else
        {
            return 'No query provided';
            die;
        }
    }
    
    //fetch one column
    public function GetOne($sql) 
    {
        $this->connect();
        
        //connect to database
        if (!empty($sql)) 
        {
            try
            {
                $re = $this->db->prepare($sql);
                $re->execute();
                return $re->fetchColumn();
            }
            catch(PDOException $e) 
            {
                return $e->getMessage();
            }
        } else
        {
            return 'No query provided';
            die;
        }
        $this->disconnect();
        
        //disconnect from database
        
        
    }
    
    //fetch one rows in a result and store it as an  object
    public function GetRow($sql) 
    {
        if (!empty($sql)) 
        {
            $this->connect();
            
            //connect to database
            try
            {
                $q = $this->db->prepare($sql);
                $q->execute();
                return $q->fetch(PDO::FETCH_OBJ);
                $this->disconnect();
                
                //disconnect from database
                
                
            }
            catch(PDOException $e) 
            {
                return $e->getMessage();
            }
        } else
        {
            return 'No query provided';
            die;
        }
    }
    
    //fetch all rows in a result to assoc_array
    public function GetAll($sql) 
    {
        $this->connect();
        
        //connect to database
        if (!empty($sql)) 
        {
            try
            {
                $q = $this->db->prepare($sql);
                $q->execute();
                $q->setFetchMode(PDO::FETCH_ASSOC);
                $data = $q->fetchAll();
                
                return $data;
                
                //echo json_encode($data);
                
                
            }
            catch(PDOException $e) 
            {
                return $e->getMessage();
            }
        } else
        {
            return 'No query provided';
            die;
        }
        
        $this->disconnect();
        
        //disconnect from database
        
        
    }
    
    //fetch one rows in a result and store it as an  object
    public function GetRowObject($sql) 
    {
        
        if (!empty($sql)) 
        {
            $this->connect();
            
            //connect to database
            try
            {
                $q = $this->db->prepare($sql);
                $q->execute();
                return $q->fetch(PDO::FETCH_OBJ);
                $this->disconnect();
                
                //disconnect from database
                
                
            }
            catch(PDOException $e) 
            {
                return $e->getMessage();
            }
        } else
        {
            return 'No query provided';
            die;
        }
    }
    
    //fetch one rows in a result and store it as  array
    public function GetRowArray($sql) 
    {
        $this->connect();
        
        //connect to database
        if (!empty($sql)) 
        {
            try
            {
                $q = $this->db->prepare($sql);
                $q->execute();
                return $q->fetch(PDO::FETCH_ASSOC);
            }
            catch(PDOException $e) 
            {
                return $e->getMessage();
            }
        } else
        {
            return 'No query provided';
            die;
        }
        $this->disconnect();
        
        //disconnect from database
        
        
    }
    
    public function server_info()
    
    /* print server version */
    
    
    {
        $this->connect();
        return $this->connect->server_info;
        $this->disconnect();
    }
    
    //delete function
    function delete($tbl, $id) 
    {
        $this->execute("DELETE FROM {$this->clean($tbl) } WHERE id='{$this->clean($id) }'");
    }
    
    //execute query supply
    public function Execute($sql) 
    {
        $this->connect();
        
        //connect to database
        if (!empty($sql)) 
        {
            $sth = $this->db->prepare($sql);
			$sth->execute();
            // return $sth->execute();
			return $sth->rowCount();
            
            //return  $sth->fetchColumn();
            
            
        } else
        {
            return 'No query provided';
            die;
        }
        
        $this->disconnect();
        
        //disconnect from database
        
        
    }
	
	    //execute Merchant query supply
    
    
    //check if column exists in the given database table
    public function checkcol($tbl, $col) 
    {
        $this->connect();
        
        //connect to database
        if (!empty($tbl)) 
        {
            try
            {
                $sql = "SELECT count(*) 
                FROM information_schema.COLUMNS 
                WHERE 
                    TABLE_SCHEMA = '" . DN . "' 
                AND TABLE_NAME = '" . $tbl . "' 
                AND COLUMN_NAME = '" . $col . "'";
                
                return $this->GetOne($sql);
            }
            catch(PDOException $e) 
            {
                return $e->getMessage();
            }
        } else
        {
            return 'No query provided';
            die;
        }
        $this->disconnect();
        
        //disconnect from database
        
        
    }
    
    function saveInfo($tbl) 
    {
        $this->connect();
        
        //connect to database
        $label = array();
        $value = array();
        $update = "";
        
        //create the table if not exist
        $tbl_col = null;
        foreach ($_POST as $f => $v) 
        {
            $tbl_col.= $f . " varchar(255) not null,";
        }
        $tbl_col = substr($tbl_col, 0, -1);
        $sql_ = "CREATE TABLE IF NOT EXISTS {$tbl} ( id int auto_increment primary key,{$tbl_col},unique key tID(tID))";
        $this->execute($sql_);
        
        //echo $sql_;
        //end of table creation if not exists
        
        //process the given data
        foreach ($_POST as $key => $val) 
        {
            $lb = $this->checkcol($tbl, $key);
            if ($lb > 0) 
            {
                $label[$key] = $key;
                if ($key == "description" || $key == "valid" || $key == "link" || strstr($key, "dob") || $key == "custom" || $key == "detail" || $key == "billdue")
                
                //
                
                
                {
                    $value[$key] = $val;
                    $update.= $key . "='" . $val . "',";
                } elseif ($key == "password") 
                {
                    
                    //$pass = md5($this->strip_html_tags($_POST['username']).$this->strip_html_tags($_POST['password']));
                    $passwo = md5(md5($this->clean($_POST['username'])) . md5($this->clean($_POST['password'])));
                    $pass = md5($passwo . PASSWORD_SALT);
                    
                    $value[$key] = $pass;
                    $update.= $key . "='" . $pass . "',";
                } else
                {
                    $value[$key] = $this->clean($val);
                    $update.= $key . "='" . $this->clean($val) . "',";
                }
            }
        }
        $update = substr($update, 0, -1);
        
        //remove the last comma
        
        //check if colum exist is table
        $cols = "";
        if (is_array($label)) 
        {
            foreach ($label as $lbl) 
            {
                $cols.= $lbl . ',';
            }
        }
        $cols = substr($cols, 0, -1);
        
        //remove the last comma
        
        $va = "";
        if (is_array($value)) 
        {
            foreach ($value as $v) 
            {
                $va.= "'" . $v . "',";
            }
        }
        $va = substr($va, 0, -1);
        
        //remove the last comma
        
        $sql = "";
        if (!empty($_POST['id'])) 
        {
            $sql = "UPDATE {$tbl} set {$update} WHERE id='{$this->clean($_POST['id']) }'";
        } else
        {
            $sql = "INSERT INTO {$tbl}({$cols}) VALUES({$va})";
        }
        
        $this->execute($sql);
        
        //print_r($_POST);
        
        $this->disconnect();
        
        //disconnect from database
        
    }
    
    //get specific column from table
    function getField($col, $sF, $sV, $tbl, $cmd, $other = null) 
    {
        return $this->$cmd("SELECT {$this->clean($col) } FROM {$this->clean($tbl) } WHERE {$this->clean($sF) }='{$this->clean($sV) }' {$other}");
    }
    
    //get specific column from table
    function getTblInfo($col, $tbl, $cmd, $cond = null) 
    {
        return $this->$cmd("SELECT {$this->clean($col) } FROM {$this->clean($tbl) } {$cond}");
    }
    
    function cipher($string) 
    {
        $output = false;
        $key = 'Abibaa';
        $action = 'encrypt';
        // initialization vector
        $iv = md5(md5($key));
        if ($action == 'encrypt') 
        {
            $output = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key) , $string, MCRYPT_MODE_CBC, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') 
        {
            $output = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key) , base64_decode($string) , MCRYPT_MODE_CBC, $iv);
            $output = rtrim($output);
        }
        return $output;
    }
}
