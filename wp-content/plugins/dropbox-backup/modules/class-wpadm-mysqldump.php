<?php
if (!class_exists('WPAdm_Mysqldump')) {
    class WPAdm_Mysqldump {

        public $charset;
        public $collate;

        public $host = '';
        public $user = '';
        public $password = '';
        public $dbh = null ;
        public $rows = 1000;

        private function connect($db = '') {
            //WPAdm_Core::log("----------------------------------------------------");
            //WPAdm_Core::log( langWPADM::get('Connecting to MySQL...' , false) );
            if (! class_exists('wpdb')) {
                require_once ABSPATH . '/' . WPINC . '/wp-db.php';
            }
            if ($this->dbh === null) {
                global $wpdb;
                if (is_object($wpdb)) {
                    $this->dbh = $wpdb;
                } else {
                    $this->dbh = new wpdb( $this->user, $this->password, $db, $this->host );
                    $errors = $this->dbh->last_error;
                    if ($errors) {
                        $this->setError( langWPADM::get('MySQL Connect failed: ' , false) . $errors);
                    }
                    if (isset($this->dbh->error->errors) && count($this->dbh->error->errors) > 0 ) {
                        $error = '';
                        foreach($this->dbh->error->errors as $key => $err) {
                            if ($key === 'db_connect_fail') {
                                $error .= "Connect fail: Check the number of connections to the database or \n";
                            }
                            $error .= strip_tags( implode("\n", ($err) ) );
                        }
                        $this->setError( $error );
                    }
                }
            }
            return $this->dbh;
        }

        public function optimize($db) {
            $proc_data = WPAdm_Running::getCommandResultData('db');
			if (!isset($proc_data['optimize'])) {
                $link = $this->connect($db);
                WPAdm_Core::log( langWPADM::get('Optimize Database Tables was started' , false) );
                $n = $link->query('SHOW TABLES');
                $result = $link->last_result;
                if (!empty( $link->last_error ) && $n > 0) {
                    $this->setError($link->last_error);
                } else {
                    for($i = 0; $i < $n; $i++ ) {
                        $res = array_values( get_object_vars( $result[$i] ) );
                        $proc_data = WPAdm_Running::getCommandResultData('db');
                        if (!isset($proc_data['optimize_table'][$res[0]])) { 
                            $link->query('OPTIMIZE TABLE '. $res[0]);
                            if (!empty( $link->last_error ) ) {
                                $tables = isset($proc_data['optimize_table']) ? $proc_data['optimize_table'] : array();
                                $tables[$res[0]] = 1;
                                $proc_data['optimize_table'] = $tables;
                                WPAdm_Running::setCommandResultData('db', $proc_data);
                                $log = str_replace('%s', $res[0], langWPADM::get('Error to Optimize Table `%s`' , false) );
                                WPAdm_Core::log($log);
                            } else {
                                $log = str_replace('%s', $res[0], langWPADM::get('Optimize Table `%s` was successfully' , false) );
                                WPAdm_Core::log($log);
                            }
                        }
                    }
                    WPAdm_Core::log( langWPADM::get('Optimize Database Tables was Finished' , false) );
                    $proc_data = WPAdm_Running::getCommandResultData('db');
                    $proc_data['optimize'] = true;
                    WPAdm_Running::setCommandResultData('db', $proc_data);
                }
            }
        }

        public function mysqldump($db, $filename) 
        {
            $proc_data = WPAdm_Running::getCommandResultData('db');
            if (!isset($proc_data['mysqldump'])) {
                $link = $this->connect($db);
                WPAdm_Core::log( langWPADM::get('MySQL of Dump was started' , false) );
                $tables = array();
                $n = $link->query('SHOW TABLES');
                $result = $link->last_result;
                if (!empty( $link->last_error )) {
                    $this->setError($link->last_error);
                    return false;
                } 
                if ($link->last_result === null) {     
                    /* foreach($link->error->errors as $key => $errors) {
                    if ($key == db_connect_fail)
                    }*/
                    $this->setError(print_r(implode("\n", $link->error->errors), 1));
                    return false;
                }
                for($i = 0; $i < $n; $i++ ) {
                    $row = array_values( get_object_vars( $result[$i] ) );
                    $tables[] = $row[0];
                }

                foreach($tables as $table) {
                    $return = '';
                    $proc_data = WPAdm_Running::getCommandResultData('db');
                    if (!isset($proc_data['mysqldump_table'][$table])) {


                        $result = $link->last_result;
                        if (!empty( $link->last_error ) && $n > 0) {
                            $this->setError($link->last_error);
                        }
                        $return.= 'DROP TABLE IF EXISTS ' . $table . ';';

                        $ress = $link->query('SHOW CREATE TABLE ' . $table);
                        $result2 = $link->last_result;
                        if (!empty( $link->last_error ) && $n > 0) {
                            $this->setError($link->last_error);
                        }
                        $row2 = array_values( get_object_vars( $result2[0]  ) );
                        $return.= "\n\n".$row2[1].";\n\n";

                        file_put_contents($filename, $return, FILE_APPEND);
                        $proc_data = WPAdm_Running::getCommandResultData('db');
                        $proc_data['mysqldump_table'][$table] = 1;
                        WPAdm_Running::setCommandResultData('db', $proc_data);
                        $log = str_replace('%s', $table, langWPADM::get('Add a table "%s" in the database dump' , false) );
                        WPAdm_Core::log( $log );
                    }
                    $while = true;
                    while($while) {
                        $table_db = WPAdm_Running::getCommandResultData('tabledb');
                        if (isset($table_db[$table])) {
                            if (isset($table_db[$table]['work']) && $table_db[$table]['work'] == true) {
                                $from = $table_db[$table]['from']; // value from
                                $to = $table_db[$table]['to']; // value to
                            }
                        } else {
                            $from = 0;
                            $to = $this->rows;
                        }
                        if (isset($from) && !empty($to) && $from >= 0 && $to >= 0) {
							unset($link);
							$link = $this->connect($db);
                            $num_fields = $link->query( 'SELECT * FROM ' . $table . " LIMIT {$from}, {$to}" );
							if ($num_fields > 0) {

                                $result2 = $link->last_result;
                                for ($i = 0; $i < $num_fields; $i++) {  
                                    $return = ''; 
                                    $row = array_values( get_object_vars( $result2[$i] ) );
                                    //WPAdm_Core::log('row' . print_r($row, 1));
                                    $rows_num = count($row);
                                    if ($rows_num > 0) {
                                        $return.= 'INSERT INTO ' . $table . ' VALUES(';
                                        for($j=0; $j < $rows_num; $j++) {
                                            $row[$j] = addslashes($row[$j]);
                                            $row[$j] = str_replace("\n","\\n",$row[$j]);
                                            if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                                            if ($j<($rows_num-1)) { $return.= ','; }
                                        }
                                        $return .= ");\n";
                                        file_put_contents($filename, $return, FILE_APPEND); 
                                        $from += 1;
                                        $table_db[$table]['from'] = $from;
                                        $table_db[$table]['to'] = $to;
                                        $table_db[$table]['work'] = true;
										WPAdm_Running::setCommandResultData('tabledb', $table_db);
										
                                    }

                                }
                                $log = str_replace(array('%s', '%from%', '%to%'), array($table, $from, $to), langWPADM::get('Add a table rows "%s" in the database dump from %from% to %to%' , false) );
                                WPAdm_Core::log( $log );
							} else {
                                $while = false;
                                $table_db[$table]['work'] = false;
                                WPAdm_Running::setCommandResultData('tabledb', $table_db);
                            }
                        } else {
                            $while = false;
                            $table_db[$table]['work'] = false;
                            WPAdm_Running::setCommandResultData('tabledb', $table_db);
                        }
                    }
                    if (!isset($proc_data['mysqldump_table'][$table])) {
                        $return ="\n\n\n";
                        file_put_contents($filename, $return, FILE_APPEND);
                    }
                }
                unset($link);
                WPAdm_Core::log( langWPADM::get('MySQL of Dump was finished' , false) ); 
                $proc_data = WPAdm_Running::getCommandResultData('db');
                $proc_data['mysqldump'] = true;
                WPAdm_Running::setCommandResultData('db', $proc_data);
                return true;
            } else {
                return false;
            }
        }

        private function setError($txt)
        {
            throw new Exception($txt);
        }

        public function restore($db, $file)
        {
            $link = $this->connect($db);
            WPAdm_Core::log( langWPADM::get('Restore Database was started' , false) );
            $fo = fopen($file, "r");
            if (!$fo) {
                WPAdm_Core::log( langWPADM::get('Error in open file dump' , false) );
                $this->setError( langWPADM::get('Error in open file dump' , false) );
                return false;
            }
            $sql = "";
            while(false !== ($char = fgetc($fo))) {
                $sql .= $char;
                if ($char == ";") {
                    $char_new = fgetc($fo);
                    if ($char_new !== false && $char_new != "\n") {
                        $sql .= $char_new;
                    } else {
                        $ress = $link->query($sql);
                        if (!empty( $link->last_error ) && $n > 0) {
                            $this->setError($link->last_error);
                            WPAdm_Core::log(langWPADM::get('MySQL Error: ' , false) . $link->last_error);
                            break;
                        };
                        $sql = "";
                    }
                }
            }
            WPAdm_Core::log(langWPADM::get('Restore Database was finished' , false));  
        }
    }
}

