<?php


namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

class RoundRobinCompetition extends Competition
{
    public function generateGrid(): Collection
    {
        foreach ($this->commands as $command)
        {

        }

        return $this->commands;
    }

    public function generateTable(): Collection
    {
        return $this->commands->sortByDesc('score');
    }
}
