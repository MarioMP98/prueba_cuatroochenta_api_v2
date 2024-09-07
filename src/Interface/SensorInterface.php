<?php

namespace App\Interface;

interface SensorInterface
{
    public function getId();

    public function getName();

    public function setName(?string $name);

    public function setCreatedAt(\DateTime $createdAt);

    public function setUpdatedAt(\DateTime $updatedAt);

    public function setDeletedAt(?\DateTime $deletedAt = null);
}