<?php

namespace App\Entity;

use App\Repository\StatisticRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatisticRepository::class)]
#[ORM\Table(name: 'tbl_statistic')]
class Statistic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $t_moyen = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $t_min = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $t_max = null;

    #[ORM\Column(nullable: true)]
    private ?int $question_asked_X_time_ = null;

    /**
     * @var Collection<int, SelectedAnswer>
     */
    #[ORM\OneToMany(targetEntity: SelectedAnswer::class, mappedBy: 'statistic')]
    private Collection $selectedAnswers;

    #[ORM\OneToOne(inversedBy: 'statistic', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Question $question = null;

    public function __construct()
    {
        $this->selectedAnswers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTMoyen(): ?string
    {
        return $this->t_moyen;
    }

    public function setTMoyen(?string $t_moyen): static
    {
        $this->t_moyen = $t_moyen;

        return $this;
    }

    public function getTMin(): ?string
    {
        return $this->t_min;
    }

    public function setTMin(?string $t_min): static
    {
        $this->t_min = $t_min;

        return $this;
    }

    public function getTMax(): ?string
    {
        return $this->t_max;
    }

    public function setTMax(?string $t_max): static
    {
        $this->t_max = $t_max;

        return $this;
    }

    public function getQuestionAskedXTime(): ?int
    {
        return $this->question_asked_X_time_;
    }

    public function setQuestionAskedXTime(?int $question_asked_X_time_): static
    {
        $this->question_asked_X_time_ = $question_asked_X_time_;

        return $this;
    }

    /**
     * @return Collection<int, SelectedAnswer>
     */
    public function getSelectedAnswers(): Collection
    {
        return $this->selectedAnswers;
    }

    public function addSelectedAnswer(SelectedAnswer $selectedAnswer): static
    {
        if (!$this->selectedAnswers->contains($selectedAnswer)) {
            $this->selectedAnswers->add($selectedAnswer);
            $selectedAnswer->setStatistic($this);
        }

        return $this;
    }

    public function removeSelectedAnswer(SelectedAnswer $selectedAnswer): static
    {
        if ($this->selectedAnswers->removeElement($selectedAnswer)) {
            // set the owning side to null (unless already changed)
            if ($selectedAnswer->getStatistic() === $this) {
                $selectedAnswer->setStatistic(null);
            }
        }

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(Question $question): static
    {
        $this->question = $question;

        return $this;
    }
}
