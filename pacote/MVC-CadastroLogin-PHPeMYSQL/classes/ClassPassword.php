<?php
namespace Classes;

class ClassPassword{

    public function passwordHash($senha)
    {
        return password_hash($senha, PASSWORD_DEFAULT);
    }
    public function verifyHash($email,$senha)
    {
        $hashDb=$this->db->getDataUser($email);
        return password_verify($senha,$hashDb["data"]["senha"]);
    }
}