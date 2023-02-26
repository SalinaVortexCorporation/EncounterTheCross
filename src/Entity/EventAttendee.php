<?php

namespace App\Entity;

use App\Repository\EventAttendeeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventAttendeeRepository::class)]
class EventAttendee
{
    use EntityIdTrait;
    use QuestionsAndConcernsTrait;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $church = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $invitedBy = null;

    #[ORM\ManyToOne(inversedBy: 'eventAttendees')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $launchPoint = null;

    public function getChurch(): ?string
    {
        return $this->church;
    }

    public function setChurch(string $church): self
    {
        $this->church = $church;

        return $this;
    }

    public function getInvitedBy(): ?string
    {
        return $this->invitedBy;
    }

    public function setInvitedBy(?string $invitedBy): self
    {
        $this->invitedBy = $invitedBy;

        return $this;
    }

    public function getLaunchPoint(): ?Location
    {
        return $this->launchPoint;
    }

    public function setLaunchPoint(?Location $launchPoint): self
    {
        $this->launchPoint = $launchPoint;

        return $this;
    }

}
