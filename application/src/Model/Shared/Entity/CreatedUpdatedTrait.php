<?php

namespace App\Model\Shared\Entity;

use DateTimeImmutable;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

trait CreatedUpdatedTrait
{
    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime_immutable")
     * @psalm-readonly
     */
    public DateTimeImmutable $created;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime_immutable")
     * @psalm-readonly-allow-private-mutation
     */
    public DateTimeImmutable $updated;

    public function setUpdated(DateTimeImmutable $updated): void
    {
        $this->updated = $updated;
    }
}
