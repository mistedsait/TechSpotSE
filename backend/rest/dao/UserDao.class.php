<?php

require_once __DIR__ . "/BaseDao.class.php";

class UserDao extends BaseDao 
{

    public function __construct()
    {
       parent::__construct('users');
    }
   public function add_user($users){
        //TODO IMPLEMENT ADD LOGIC
        $query= "INSERT INTO users(first_name,last_name, email,password)
                VALUES(:firstname, :lastname,:email, :password)";
        $statement=$this->connection->prepare($query);
        $statement->execute($users);
        $users['id']=$this->connection->lastInsertId();
        return $users;
    }
    public function delete_user($id){
        return $this->execute("DELETE FROM users WHERE id = :id", ['id' => $id]);

    }
    public function update_user($id, $user) {
        $this->execute_update('users', $id, $user);
    }

    public function get_user_by_id($id) {
        return $this->query_unique("SELECT * FROM users WHERE id = :id", ["id" => $id]);
    }
}
