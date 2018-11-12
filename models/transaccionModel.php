<?php

class TransaccionModel extends AppModel
{

    public function __construct()
    {

        parent::__construct();

    }

    public function findAll()
    {
        $query = $this->_db->query("SELECT t.*, a.name AS account, c.name AS category FROM transactions AS t JOIN accounts a on t.account_id = a.id JOIN categories c on t.category_id = c.id");
        return $query->fetchAll();
    }

    public function find($id)
    {
        $query = $this->_db->prepare("SELECT * FROM transactions WHERE id = :id");
        $query->bindParam(":id", $id);
        $query->execute();
        return $query->fetch();
    }

    public function add($data)
    {
        $query = $this->_db->prepare("INSERT INTO transactions (account_id, category_id, description, date, amount) VALUES (:account_id, :category_id, :description, :date, :amount)");
        $query->bindParam(":account_id", $data['account_id']);
        $query->bindParam(":category_id", $data['category_id']);
        $query->bindParam(":description", $data['description']);
        $query->bindParam(":date", $data['date']);
        $query->bindParam(":amount", $data['amount']);
        return $query->execute();
    }

    public function edit($data)
    {
        $query = $this->_db->prepare("UPDATE transactions SET account_id = :account_id, category_id = :category_id, description = :description, date = :date, amount = :amount WHERE id = :id");
        $query->bindParam(":id", $data['id']);
        $query->bindParam(":account_id", $data['account_id']);
        $query->bindParam(":category_id", $data['category_id']);
        $query->bindParam(":description", $data['description']);
        $query->bindParam(":date", $data['date']);
        $query->bindParam(":amount", $data['amount']);
        return $query->execute();
    }

    public function delete($id)
    {
        $query = $this->_db->prepare("DELETE FROM transactions WHERE id = :id");
        $query->bindParam(":id", $id);
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }

    }
}