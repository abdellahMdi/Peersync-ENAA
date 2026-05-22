<?php

class UserBadge
{
    private ?int $id;
    private int  $userId;
    private int  $skillId;
    private int  $badgeId;
    public function __construct(int $userId, int $skillId, int $badgeId, int $id) {
        $this->userId = $userId;
        $this->skillId = $skillId;
        $this->badgeId = $badgeId;
        $this->id = $id;
    }
    // ── Getters ──────────────────────────────────────────────
    public function getId(): ?int      { return $this->id; }
    public function getUserId(): int   { return $this->userId; }
    public function getSkillId(): int  { return $this->skillId; }
    public function getBadgeId(): int  { return $this->badgeId; }
    // ── Setters ──────────────────────────────────────────────
    public function setId(int $id): void      { $this->id = $id; }
    public function setUserId(int $id): void  { $this->userId = $id; }
    public function setSkillId(int $id): void { $this->skillId = $id; }
    public function setBadgeId(int $id): void { $this->badgeId = $id; }
}