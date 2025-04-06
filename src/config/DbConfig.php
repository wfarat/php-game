<?php

namespace App\config;

interface DbConfig
{
    public function getDsn(): string;
    public function getUser(): string;
    public function getPass(): string;
}
