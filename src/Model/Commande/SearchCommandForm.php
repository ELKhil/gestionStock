<?php

namespace App\Model\Commande;

use App\Entity\Client;
use App\Entity\Etats;

use Symfony\Component\Validator\Constraints as Assert;

class SearchCommandForm
{
    public ?string $reference = null;
    public Client|null $client = null;
    public ?\DateTime $startAt = null;
    public ?\DateTime $endAt = null;
    public Etats|null $etats = null;
}