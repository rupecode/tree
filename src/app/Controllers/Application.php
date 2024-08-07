<?php

namespace App\Controllers;

use App\Exceptions\ApiForbiddenException;
use App\Exceptions\ForbiddenException;
use App\Http\Response;
use App\Request\Request;
use DI\NotFoundException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class Application
{
    public function __construct(
        private Request            $request,
        private ContainerInterface $container
    )
    {
    }

    /**
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function run(): void
    {
        session_start();

        $action = $this->request->get('action', 'index/index');
        $parts = explode('/', $action);

        $controller = strtolower(Request::getValue($parts, 0, 'index'));
        $action = strtolower(Request::getValue($parts, 1, 'index'));

        $class = 'App\Controllers\\' . ucfirst($controller) . 'Controller';

        try {
            $instance = $this->container->get($class);
        } catch (NotFoundException $e) {
            header("HTTP/1.0 404 Not Found");

            return;
        }

        if (!method_exists($instance, $action)) {
            header("HTTP/1.0 404 Not Found");

            return;
        }

        try {
            /** @var Response $result */
            $result = call_user_func(array($instance, $action));

            if (!empty($result->getRedirectUrl())) {
                header('Location: ' . $result->getRedirectUrl());

                return;
            }

            if (is_object($result->getData())) {
                $result->setBody(json_encode($result->getData()));
                $result->setContentType('application/json');
            }

            header('Content-Type:' . $result->getContentType());
            echo $result->getBody();
        } catch (ForbiddenException $e) {
            header('Location: /');

            return;
        } catch (ApiForbiddenException $e) {
            header("HTTP/1.0 403 Forbidden");

            return;
        }
    }
}
