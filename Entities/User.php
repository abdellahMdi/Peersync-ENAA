<?php

class User
{
    private int    $id;
    private string  $name;
    private string  $email;
    private string  $password;
    private string  $firstTime;   // '0' | '1'
    private int     $roleId;

    public function __construct( string  $name, string  $email, string  $password, string  $firstTime, int     $roleId, int    $id
    ) {
        $this->name      = $name;
        $this->email     = $email;
        $this->password  = $password;
        $this->firstTime = $firstTime;
        $this->roleId    = $roleId;
        $this->id        = $id;
    }

    // ── Getters ──────────────────────────────────────────────
    public function getId(): int      { return $this->id; }
    public function getName(): string  { return $this->name; }
    public function getEmail(): string { return $this->email; }
    public function getPassword(): string { return $this->password; }
    public function getFirstTime(): string { return $this->firstTime; }
    public function getRoleId(): int   { return $this->roleId; }

}