<?php

namespace App\Interface;


interface WineAbstractFactory
{
    public function createWine(): WineInterface;
}
