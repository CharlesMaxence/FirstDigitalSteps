<?php

namespace App\Entity;

use App\Repository\SelectedAnswerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SelectedAnswerRepository::class)]
#[ORM\Table(name: 'tbl_selected_answer')]
class SelectedAnswer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $selected_answer_X_time = null;

    #[ORM\ManyToOne(inversedBy: 'selectedAnswers')]
    private ?Statistic $statistic = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Answer $answer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSelectedAnswerXTime(): ?int
    {
        return $this->selected_answer_X_time;
    }

    public function setSelectedAnswerXTime(?int $selected_answer_X_time): static
    {
        $this->selected_answer_X_time = $selected_answer_X_time;

        return $this;
    }

    public function getStatistic(): ?Statistic
    {
        return $this->statistic;
    }

    public function setStatistic(?Statistic $statistic): static
    {
        $this->statistic = $statistic;

        return $this;
    }

    public function getAnswer(): ?Answer
    {
        return $this->answer;
    }

    public function setAnswer(?Answer $answer): static
    {
        $this->answer = $answer;

        return $this;
    }
}
