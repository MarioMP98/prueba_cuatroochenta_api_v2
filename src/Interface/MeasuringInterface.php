<?php

namespace App\Interface;

use DateTime;

interface MeasuringInterface
{
    public function getId();

    public function getYear();

    public function setYear(?int $year);

    public function setCreatedAt(DateTime $createdAt);

    public function setUpdatedAt(DateTime $updatedAt);

    public function setDeletedAt(?DateTime $deletedAt = null);

    public function getValue();

    public function setValue($value): static;

    public function parse(): array;
}
