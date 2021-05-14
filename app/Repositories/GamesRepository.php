<?php


namespace App\Repositories;


use App\Models\Games;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GamesRepository extends Repository
{
    private ResourceCollection $commands;
    protected Repository $commandsRepository;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Games();
        $this->commandsRepository = new CommandsRepository();

        $this->commands = $this->commandsRepository->listCommands();
    }

    /**
     * @return Collection
     */
    public function getCommands(): ResourceCollection
    {
        return $this->commands;
    }

    public function listGames(int $stage = 1)
    {
        $repo = $this->commandsRepository;
        $games = [];

        $cmds = $repo->getModel()->all();
        foreach ($cmds as $cmd)
        {
            $cmdGames = $cmd->games->where('stage', $stage);

            if(!isset($games[$cmd->division_id])) $games[$cmd->division_id] = [];

            $games[$cmd->division_id][] = [
                'id' => $cmd['id'],
                'name' => $cmd['name'],
                'division' => $cmd['division_id'],
                'games' => $cmdGames,
            ];
        }

        return $games;
    }

    public function getById(int $id)
    {
        return $this->model->find($id);
    }

    public function save(Model $model)
    {
        $model->saveOrFail();
    }
}
