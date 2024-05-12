<?php

require_once __DIR__ . "/../config.php";

class BaseDao
{
    protected $connection;
    private $table;

    public function __construct($table)
    {
        $this->table = $table;
        try {
            $this->connection = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT,
                DB_USER,
                DB_PASSWORD,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            throw $e;
        }
    }
    
    protected function query($query, $params) {
        $statement = $this->connection->prepare($query);
        $statement->execute($params);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function query_unique($query, $params) {
        $results = $this->query($query, $params);
        return reset($results);
    }

    protected function execute($query, $params) {
        $prepared_statement = $this->connection->prepare($query);
        if ($params) {
        foreach ($params as $key => $param) {
            $prepared_statement->bindValue($key, $param);
        }
        }
        $prepared_statement->execute();
        return $prepared_statement;
    }

    public function insert($table, $entity) {
        $query = "INSERT INTO {$table} (";
        // INSERT INTO patients (
        foreach ($entity as $column => $value) {
        $query .= $column . ", ";
        }
        // INSERT INTO patients (first_name, last_name, 
        $query = substr($query, 0, -2);
        // INSERT INTO patients (first_name, last_name
        $query .= ") VALUES (";
        // INSERT INTO patients (first_name, last_name) VALUES (
        foreach ($entity as $column => $value) {
        $query .= ":" . $column . ", ";
        }
        // INSERT INTO patients (first_name, last_name) VALUES (:first_name, :last_name, 
        $query = substr($query, 0, -2);
        // INSERT INTO patients (first_name, last_name) VALUES (:first_name, :last_name
        $query .= ")";
        // INSERT INTO patients (first_name, last_name) VALUES (:first_name, :last_name)

        $statement = $this->connection->prepare($query);
        $statement->execute($entity); // SQL injection prevention
        $entity['id'] = $this->connection->lastInsertId();
        return $entity;
    }
    protected function execute_update($table, $id, $entity, $id_column = "id")
  {
    $query = "UPDATE {$table} SET ";
    foreach ($entity as $name => $value) {
      $query .= $name . "= :" . $name . ", ";
    }
    $query = substr($query, 0, -2);
    $query .= " WHERE {$id_column} = :id";

    $stmt = $this->connection->prepare($query);
    $entity['id'] = $id;
    $stmt->execute($entity);
  }
  public function add($entity)
  {
    return $this->insert($this->table, $entity);
  }
  public function update($id, $entity)
  {
    $this->execute_update($this->table, $id, $entity);
  }
  public function get_by_id($id)
  {
    return $this->query_unique("SELECT * FROM " . $this->table . " WHERE id = :id", ["id" => $id]);
  }
  
  public function get_all($offset = 0, $limit = 25, $order = "id") 
{
  list($order_column, $order_direction) = self::parse_order($order);

  return $this->query("SELECT *
                       FROM " . $this->table . "
                       ORDER BY {$order_column} {$order_direction}
                       LIMIT {$limit} OFFSET {$offset}", []);
}
protected function parse_order($order)
  {
 
    $order_direction = substr($order, 0, 1) == '-' ? 'DESC' : 'ASC';
    
  
    $order_column = $order_direction == 'DESC' ? substr($order, 1) : $order;

    return [$order_column, $order_direction];
  }
}