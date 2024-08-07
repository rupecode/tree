<?php

namespace App\Controllers;

use App\Dto\ApiResponseDto;
use App\Http\Response;
use App\Repositories\UsersRepository;
use App\Request\Request;
use App\Services\SessionService;
use League\Plates\Engine;

class IndexController extends BaseController
{
    public function __construct(
        private Engine $tpl,
        private Request $request,
        private UsersRepository $usersRepository,
        private SessionService $sessionService,
        private Response $response,
    )
    {
    }

    /**
     * @return Response
     * @throws \Throwable
     */
    public function index(): Response
    {
        if ($this->sessionService->isAuth()) {
            $this->response->setRedirectUrl('/?action=tree/index');


            return $this->response;
        }

        $t = $this->tpl->make('login');
        $this->response->setBody($t->render());

        return $this->response;
    }

    /**
     * @return ApiResponseDto
     */
    public function login(): Response
    {
        $apiResponse = new ApiResponseDto();

        if ($this->request->get('email') !== null) {

            try {
                $this->usersRepository->getUser(
                    $this->request->get('email'),
                    $this->request->get('password'),
                );
                $this->sessionService->setAuth();
            } catch (\Throwable $t) {
                $apiResponse->error = true;
                $apiResponse->message = 'Invalid credentials';
            }
        }

        $this->response->setData($apiResponse);

        return $this->response;
    }

    public function logout(): Response
    {
        $this->sessionService->removeAuth();

        return $this->response;
    }
}
