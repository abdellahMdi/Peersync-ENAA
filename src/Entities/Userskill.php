<?php

class UserSkill
{
    private int   $id;
    private string $maitrise;   // 'maîtrisées' | 'à travailler'
    private int    $skillId;
    private int    $userId;
    public function __construct( string $maitrise, int $skillId, int $userId,int $id) {
        $this->maitrise = $maitrise;
        $this->skillId = $skillId;
        $this->userId  = $userId;
        $this->id      = $id;
    }
    // ── Getters ──────────────────────────────────────────────
    public function getId(): ?int       { return $this->id; }
    public function getMaitrise(): string { return $this->maitrise; }
    public function getSkillId(): int   { return $this->skillId; }
    public function getUserId(): int    { return $this->userId; }
    // ── Setters ──────────────────────────────────────────────
    public function setId(int $id): void { $this->id = $id; }
    public function setMaitrise(string $maitrise): void { $this->maitrise = $maitrise; }
    public function setSkillId(int $skillId): void { $this->skillId = $skillId; }
    public function setUserId(int $userId): void   { $this->userId  = $userId; }
}