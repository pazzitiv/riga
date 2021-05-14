<?php


namespace App\Repositories;


use App\Http\Resources\CommandResource;
use App\Models\Command;
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

    public function getById(int $id)
    {
        return $this->model->find($id);
    }

    public function save(Model $model)
    {
        $model->saveOrFail();
    }
}
