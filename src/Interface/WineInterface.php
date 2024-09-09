<?php

namespace App\Interface;

interface WineInterface
{
    public function getId();

    public function getName();

    public function setName(?string $name);

    public function getYear();

    public function setYear(?int $year);

    public function parse();
}
