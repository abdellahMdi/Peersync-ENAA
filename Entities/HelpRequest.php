<?php

class HelpRequest
{
    private ?int     $id;
    private string   $title;
    private string   $description;
    private DateTime $datePub;
    private ?DateTime $dateSession;
    private int      $learnerId;
    private ?int     $tutorId;
    private int      $skillId;
    private int      $statusId;
    public const STATUS_EN_ATTENTE = 1;
    public const STATUS_ASSIGNE    = 2;
    public const STATUS_RESOLUE    = 3;

    public function __construct(string $title, string $description, DateTime $datePub, int $learnerId, int $skillId, int $statusId = self::STATUS_EN_ATTENTE, ?DateTime $dateSession = null, ?int $tutorId = null, ?int $id = null
    ) {
        $this->title       = $title;
        $this->description = $description;
        $this->datePub     = $datePub;
        $this->learnerId   = $learnerId;
        $this->skillId     = $skillId;
        $this->statusId    = $statusId;   // always EN_ATTENTE on creation
        $this->dateSession = $dateSession;
        $this->tutorId     = $tutorId;
        $this->id          = $id;
    }
    // ── Getters ──────────────────────────────────────────────

    public function getId(): ?int           { return $this->id; }
    public function getTitle(): string      { return $this->title; }
    public function getDescription(): string { return $this->description; }
    public function getDatePub(): DateTime  { return $this->datePub; }
    public function getDateSession(): ?DateTime { return $this->dateSession; }
    public function getLearnerId(): int     { return $this->learnerId; }
    public function getTutorId(): ?int      { return $this->tutorId; }
    public function getSkillId(): int       { return $this->skillId; }
    public function getStatusId(): int      { return $this->statusId; }

    // ── Setters ──────────────────────────────────────────────

    public function setId(int $id): void    { $this->id = $id; }
    public function setTitle(string $title): void { $this->title = $title; }
    public function setDescription(string $desc): void { $this->description = $desc; }
    public function setDatePub(DateTime $date): void   { $this->datePub = $date; }
    public function setDateSession(?DateTime $date): void { $this->dateSession = $date; }
    public function setSkillId(int $skillId): void { $this->skillId = $skillId; }
}