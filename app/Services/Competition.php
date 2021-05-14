<?php


namespace App\Services;


use App\Models\Command;
use Illuminate\Database\Eloquent\Collection;

abstract class Competition
{
    /**
     * @var Collection
     */
    protected Collection $commands;

    /**
     * Competition constructor.
     * @param $allCommands - all commands of tournament
     */
    public function __construct(Collection $allCommands)
    {
        $this->commands = $allCommands;
    }

    /**
     * @param Collection $allCommands
     * @return Competition
     */
    public function updateCommands(Collection $allCommands): Competition
    {
        $this->commands = $allCommands;

        return $this;
    }

    public function Winner(int $command_id): Competition
    {
        $command = $this->commands->find($command_id);

        throw_if($command === null, new \Exception('Wrong command', 422));

        $command->score = $command->score + 3;
        $command->saveOrFail();

        $this->updateCommands(Command::all());

        return $this;
    }

    public function Draw(int $command_id, int $rival_id): Competition
    {
        $command = $this->commands->find($command_id);

        throw_if($command === null, new \Exception('Wrong command', 422));

        $command->score++;
        $command->saveOrFail();

        $command = $this->commands->find($rival_id);

        throw_if($command === null, new \Exception('Wrong rival command', 422));

        $command->score++;
        $command->saveOrFail();

        $this->updateCommands(Command::all());

        return $this;
    }
}
