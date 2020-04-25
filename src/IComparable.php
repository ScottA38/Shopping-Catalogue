<?php

declare(strict_types=1);

namespace WebApp;

interface IComparable
{
    public function compareTo(IComparable $other): bool;
}
