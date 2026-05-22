<?php
require_once __DIR__ . "/User.php";
require_once __DIR__ . "/Skill.php";

class HelpRequest
{
    private ?int     $id;
    private string   $title;
    private string   $description;
    private DateTime $datePub;
    private ?DateTime $dateSession;
    public User      $learner;
    public ?User     $tutor;
    public Skill    $skill;
    private string      $status;
    
    public function __construct(string $title, string $description, DateTime $datePub, User $learner, Skill $skill, string $status , ?DateTime $dateSession = null, ?User $tutor = null, ?int $id = null
    ) {
        $this->title       = $title;
        $this->description = $description;
        $this->datePub     = $datePub;
        $this->learner   = $learner;
        $this->skill     = $skill;
        $this->status    = $status;   // always EN_ATTENTE on creation
        $this->dateSession = $dateSession;
        $this->tutor     = $tutor;
        $this->id          = $id;
    }
    // ── Getters ──────────────────────────────────────────────
    public function getId(): ?int           { return $this->id; }
    public function getTitle(): string      { return $this->title; }
    public function getDescription(): string { return $this->description; }
    public function getDatePub(): string  { return $this->datePub->format('Y-m-d H:i:s'); }
    public function getDateSession(): ?string { return $this->dateSession->format('Y-m-d H:i:s'); }
    public function getStatus(): string      { return $this->status; }
    // ── Setters ──────────────────────────────────────────────
    public function setId(int $id): void    { $this->id = $id; }
    public function setTitle(string $title): void { $this->title = $title; }
    public function setDescription(string $desc): void { $this->description = $desc; }
    public function setDatePub(DateTime $date): void   { $this->datePub = $date; }
    public function setDateSession(?DateTime $date): void { $this->dateSession = $date; }
}