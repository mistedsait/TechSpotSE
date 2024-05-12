<?php

require_once __DIR__ . "/../dao/UserDao.class.php";

class UserService {
    
    private $user_dao;

    public function __construct(){
        $this->user_dao = new UserDao();
    }

    public function add_user($users){
        return $this->user_dao->add_user($users);
    }

    public function get_user_by_id($user_id) {
        return $this->user_dao->get_user_by_id($user_id);
    }
    public function get_all_users($offset = 0, $limit = 25, $order = "id") {
        return $this->user_dao->get_all($offset, $limit, $order);
    }
    public function update_user($user_id, $user) {
        $this->user_dao->update_user($user_id, $user);
    }

    public function delete_user_by_id($user_id) {
        return $this->user_dao->delete_user($user_id);
    }
}
echo __DIR__ . "/dao/UserDao.class.php";