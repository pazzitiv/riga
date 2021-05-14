<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommandResource;
use App\Http\Resources\GamesResource;
use App\Models\Command;
use App\Models\Division;
use App\Models\Games;
use App\Repositories\GamesRepository;
use App\Services\RoundRobinCompetition;
use Illuminate\Http\JsonResponse;

class GridController extends Controller
{
    public function initRepo(): void
    {
        $this->setRepository(new GamesRepository());
    }

    /**
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        $divisions = Division::all();
        $result = [
            'divisions' => $divisions,
            'grids' => [
                'roundrobin' => [
                    'table' => [],
                    'scorelists' => [],
                ],
                'singleelimination' => [

                ],
            ]
        ];

        $grids = &$result['grids'];

        $grids['roundrobin']['table'] = $this->repository->listGames();

        foreach ($divisions->pluck('id') as $division) {
            $competition = new RoundRobinCompetition(Command::where('division_id', $division)->get());
            $table = CommandResource::collection($competition->generateTable());

            $grids['roundrobin']['scorelists'][$division] = $table;
        }

        $games = Games::where('stage', 1);
        if ($games->count() > 0) {
            if ($games->where('release', false)->count() === 0) {
                $grids['singleelimination'][0] = [
                    $grids['roundrobin']['scorelists'][1]->values()->offsetGet(0),
                    $grids['roundrobin']['scorelists'][2]->values()->offsetGet(1),
                ];
                $grids['singleelimination'][1] = [
                    $grids['roundrobin']['scorelists'][2]->values()->offsetGet(0),
                    $grids['roundrobin']['scorelists'][1]->values()->offsetGet(1),
                ];
            }
        }

        return \response()->json($result);
    }

    public function generate(): JsonResponse
    {
        $commands = $this->repository->getCommands()->toArray(\request());

        $divisionCommands = [];

        foreach ($commands as $command) {
            if(!isset($divisionCommands[$command['division']['id']])) $divisionCommands[$command['division']['id']] = [];

            $divisionCommands[$command['division']['id']][] = $command;
        }

        $this->repository->getModel()->truncate();
        foreach ($divisionCommands as $index => $divisionCommand) {
            shuffle($divisionCommand);
            foreach ($divisionCommand as $cmd) {
                $rivals = array_filter($divisionCommand, fn($item) => $item['id'] !== $cmd['id']);
                foreach ($rivals as $rival)
                {
                    $model = clone $this->repository->getModel();
                    $model->fill([
                        'left_team' => $cmd['id'],
                        'right_team' => $rival['id'],
                        'stage' => 1,
                    ]);
                    $this->repository->save($model);
                }
            }
        }

        return $this->list();
    }
}
