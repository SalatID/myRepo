<?php

//buat koneksi
  class config extends PDO{
    private $engine;
    private $host;
    private $database;
    private $user;
    private $pass;
    private $error;
    private $result;

    public function __construct(){

      $this->engine   = 'mysql';
      $this->host     = 'localhost';
      $this->database = 'kiosaya';
      $this->user     = 'root';
      $this->pass     = 'root';

      $dns = $this->engine.':host='.$this->host.';dbname='.$this->database;
      parent::__construct( $dns, $this->user, $this->pass );
    }
    //menambahkan value ke table
        public function insert($table,$rows=null){
          $command = "insert into ".$table;
          $row = null; $value=null;
          foreach ($rows as $key => $nilainya) {
            $row .=",".$key;
            $value .=", :".$key;
          }
          $command .="(".substr($row,1).")";
          $command .="VALUES(".substr($value,1).")";

          $stmt = parent::prepare($command);
          $stmt->execute ($rows);
          $rowcount = $stmt->rowcount();
          return $rowcount;
        }
    /*
   * Delete records from the database.
   */
       public function delete($table,$where=null)
       {
               $command = 'DELETE FROM '.$table;

               $list = Array(); $parameter = null;
               foreach ($where as $key => $value)
               {
                 $list[] = "$key = :$key";
                 $parameter .= ', ":'.$key.'":"'.$value.'"';
               }
               $command .= ' WHERE '.implode(' AND ',$list);

               $json = "{".substr($parameter,1)."}";
               $param = json_decode($json,true);

               $query = parent::prepare($command);
               $query->execute($param);
               $rowcount = $query->rowCount();
       return $rowcount;
       }

       /*
   * Uddate Record
   */
       public function update($tabel, $fild = null ,$where = null)
       {
         $update = 'UPDATE '.$tabel.' SET ';
         $set=null; $value=null;
         foreach($fild as $key => $values)
         {
                 $set .= ', '.$key. ' = :'.$key;
                 $value .= ', ":'.$key.'":"'.$values.'"';
         }
         $update .= substr(trim($set),1);

         if($where != null)
         {
            $update .= ' WHERE '.$where;
         }

         $query = parent::prepare($update);
         $query->execute($fild);
         $rowcount = $query->rowCount();
         return $rowcount;
   }
    /*
    * Selects information from the database.
    */
        public function select($table, $rows,$on=null, $where = null, $group=null,$order = null, $limit= null)
        {
            $command = 'SELECT '.$rows.' FROM '.$table;
        if($on != null)
            $command .= ' ON '.$on;
        if($where != null)
            $command .= ' WHERE '.$where;
        if($group != null)
            $command .= ' GROUP BY '.$group;
        if($order != null)
            $command .= ' ORDER BY '.$order;
        if($limit != null)
            $command .= ' LIMIT '.$limit;

                $query = parent::prepare($command);
                $query->execute();

                $posts = array();
                while($row = $query->fetch(PDO::FETCH_ASSOC))
                {
                         $posts[] = $row;
                }
                return $this->result = json_encode(array('response'=>$posts));
        }

        public function logout(){
            // Hapus session
            session_destroy();
            // Hapus user_session
            unset($_SESSION['user_session']);
            return true;
            }
        public function getResult()
            {
            return $this->result;
        }

      }
 ?>
