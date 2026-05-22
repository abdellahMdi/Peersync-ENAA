<?php

class Skill
{
    private int   $id;
    private string $name;
    private string $dificulti;   // 'easy' | 'medium' | 'hard'
    
    public function __construct(string $name, string $dificulti, int $id ){
        $this->name = $name;
        $this->dificulti = $dificulti;
        $this->id   = $id;
    }
    // ── Getters ──────────────────────────────────────────────
    public function getId(): ?int      { return $this->id; }
    public function getName(): string  { return $this->name; }
    public function getDificulti(): string { return $this->dificulti; }
    // ── Setters ──────────────────────────────────────────────
    public function setId(int $id): void { $this->id = $id; }
    public function setName(string $name): void { $this->name = $name; }
    public function setDificulti(string $dificulti): void { $this->dificulti = $dificulti;}
}