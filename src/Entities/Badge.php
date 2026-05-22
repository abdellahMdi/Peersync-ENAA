<?php

class Badge
{
    private int   $id;
    private int    $requirements;
    private string $name;
    public function __construct(int $requirements, string $name, int $id) {
        $this->requirements = $requirements;
        $this->name = $name;
        $this->id   = $id;
    }
    // ── Getters ──────────────────────────────────────────────
    public function getId(): ?int          { return $this->id; }
    public function getRequirements(): int { return $this->requirements; }
    public function getName(): string      { return $this->name; }
    // ── Setters ──────────────────────────────────────────────
    public function setId(int $id): void { $this->id = $id; }
    public function setRequirements(int $requirements): void { $this->requirements = $requirements;}
    public function setName(string $name): void { $this->name = $name; }
}