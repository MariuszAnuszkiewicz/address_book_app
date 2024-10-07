<?php

declare(strict_types=1);

class User extends Model {

    public function getAll()
    {
        $sql = "SELECT * FROM users ORDER BY id ASC";
        $this->db->query($sql);
        $result = $this->db->results();
        if (isset($result)) {
            return $result;
        }
        return false;
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM users WHERE id = ? ORDER BY id ASC";
        $this->db->query($sql, [$id]);
        $result = $this->db->results();
        if (isset($result[0])) {
            return $result[0];
        }
    }

    public function deleteById($id)
    {
        $sql = "DELETE FROM users WHERE id = ?";
        $this->db->query($sql, [$id]);
    }

    public function create(string $name = '', string $surname = '', int $phone , string $email = '')
    {
        $sql = "INSERT INTO users (name, surname, phone, email) VALUES (?, ?, ?, ?)";
        $this->db->query($sql, [$name, $surname, $phone, $email]);
    }

    public function update(string $name = '', string $surname = '', int $phone, string $email = '', $id)
    {
        $sql = "UPDATE users SET name = ?, surname = ?, phone = ?, email = ? WHERE id = ?";
        $this->db->query($sql, [$name, $surname, $phone, $email, $id]);
    }
}

