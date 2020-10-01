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
     */
    protected DateTimeImmutable $created;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime_immutable")
     */
    protected DateTimeImmutable $updated;

    public function getCreated(): DateTimeImmutable
    {
        return $this->created;
    }

    public function setCreated(DateTimeImmutable $created): void
    {
        $this->created = $created;
    }

    public function getUpdated(): DateTimeImmutable
    {
        return $this->updated;
    }

    public function setUpdated(DateTimeImmutable $updated): void
    {
        $this->updated = $updated;
    }
}
