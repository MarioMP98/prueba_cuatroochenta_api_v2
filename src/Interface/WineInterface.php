<?php

namespace App\Interface;

use DateTime;

interface WineInterface
{
    public function getId();

    public function getName();

    public function setName(?string $name);

    public function getYear();

    public function setYear(?int $year);

    public function setCreatedAt(DateTime $createdAt);

    public function setUpdatedAt(DateTime $updatedAt);

    public function setDeletedAt(?DateTime $deletedAt = null);
}
