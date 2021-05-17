<?php


namespace App\Repositories;


use App\Http\Resources\CommandResource;
use App\Models\Command;
use App\Models\Division;
use Exception;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Eloquent\Model;

class CommandsRepository extends Repository
{
    /**
     * CommandsRepository constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->model =  new Command();
    }

    public function listCommands()
    {
        return CommandResource::collection(Command::all());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    public function generateCommands()
    {
        Command::truncate();

        return Command::factory()
            ->count(20)
            ->state(new Sequence(
                [
                    'division_id' => 1
                ],
                [
                    'division_id' => 2
                ],
            ))
            ->create();
    }

    public function createCommand(string $commandName)
    {
        $model = clone $this->getModel();
        $model->name = $commandName;

        $divisions = Division::all()->pluck('id')->toArray();

        throw_if(count($divisions) === 0, new \Exception("No divisions", 422));

        $model->division_id = $divisions[rand(0, count($divisions) - 1)];

        throw_if(! $this->save($model), new Exception("Create error", 400));

        return response()->json(['status' => 'created'], 201);
    }

    public function getById(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * @param Model $model
     * @return bool
     * @throws \Throwable
     */
    public function save(Model $model): bool
    {
        return $model->saveOrFail();
    }
}
