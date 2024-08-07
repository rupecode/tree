<?php

namespace App\Controllers;

use App\Dto\ApiResponseDto;
use App\Exceptions\ApiForbiddenException;
use App\Exceptions\ForbiddenException;
use App\Http\Response;
use App\Request\Request;
use App\Services\SessionService;
use App\Services\TreeService;
use League\Plates\Engine;

class TreeController extends BaseController
{
    public function __construct(
        private Response $response,
        private Request $request,
        private SessionService $sessionService,
        private Engine $tpl,
        private TreeService $treeService
    )
    {
    }

    public function index(): Response
    {
        if (!$this->sessionService->isAuth()) {
            throw new ForbiddenException();
        }

        $t = $this->tpl->make('tree', ['tree' => $this->treeService->getTree()]);
        $this->response->setBody($t->render());

        return $this->response;
    }

    public function add(): Response
    {
        if (!$this->sessionService->isAuth()) {
            throw new ApiForbiddenException();
        }

        $this->treeService->add(
            $this->request->get('id'),
            $this->request->get('name'),
            $this->request->get('description'),
        );

        return $this->response;
    }

    public function delete(): Response
    {
        if (!$this->sessionService->isAuth()) {
            throw new ApiForbiddenException();
        }

        $this->treeService->delete(
            $this->request->get('id')
        );

        return $this->response;
    }

    public function get(): Response
    {
        if (!$this->sessionService->isAuth()) {
            throw new ApiForbiddenException();
        }

        $apiResponse = new ApiResponseDto();
        $apiResponse->data = $this->treeService->get(
            $this->request->get('id')
        );
        $this->response->setData($apiResponse);

        return $this->response;
    }

    public function edit(): Response
    {
        if (!$this->sessionService->isAuth()) {
            throw new ApiForbiddenException();
        }

        $this->treeService->update(
            $this->request->get('id'),
            $this->request->get('parent'),
            $this->request->get('name'),
            $this->request->get('description'),
        );

        return $this->response;
    }
}
