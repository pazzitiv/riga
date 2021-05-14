<?php

namespace App\Http\Controllers;

use App\Repositories\Repository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected Repository $repository;

    public function callAction($method, $parameters)
    {
        $this->initRepo();
        return parent::callAction($method, $parameters);
    }

    public function initRepo(): void
    {
    }

    /**
     * @param Repository $repository
     */
    public function setRepository(Repository $repository): void
    {
        $this->repository = $repository;
    }
}
