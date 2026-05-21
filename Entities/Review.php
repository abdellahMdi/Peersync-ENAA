<?php

class Review
{
    private ?int    $id;
    private ?string $comment;
    private int     $rating;
    private int     $reviewerId;
    private int     $helpQuestId;

    public function __construct(int $rating,int $reviewerId,int $helpQuestId,?string $comment = null,int $id = null) 
    {
        $this->setRating($rating);
        $this->reviewerId  = $reviewerId;
        $this->helpQuestId = $helpQuestId;
        $this->comment     = $comment;
        $this->id          = $id;
    }
    // ── Getters ──────────────────────────────────────────────

    public function getId(): ?int         { return $this->id; }
    public function getComment(): ?string { return $this->comment; }
    public function getRating(): int      { return $this->rating; }
    public function getReviewerId(): int  { return $this->reviewerId; }
    public function getHelpQuestId(): int { return $this->helpQuestId; }
     // ── Setters ──────────────────────────────────────────────

    public function setId(int $id): void { $this->id = $id; }
    public function setComment(?string $comment): void { $this->comment = $comment; }
    public function setRating(int $rating): void { $this->rating = $rating;}
    public function setReviewerId(int $reviewerId): void   { $this->reviewerId = $reviewerId; }
    public function setHelpQuestId(int $helpQuestId): void { $this->helpQuestId = $helpQuestId; }
}