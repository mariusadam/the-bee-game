<?php

declare(strict_types=1);

namespace BeeGame\Controller;

use BeeGame\Http\ControllerInterface;
use BeeGame\Http\Request;
use BeeGame\Http\Response;
use BeeGame\Http\Session;
use BeeGame\Templating\TemplateEngineInterface;

class PlayController implements ControllerInterface
{
    private Session $session;
    private TemplateEngineInterface $templateEngine;

    public function __construct(Session $session, TemplateEngineInterface $templateEngine)
    {
        $this->session = $session;
        $this->templateEngine = $templateEngine;
    }

    public function __invoke(Request $request): Response
    {
        $game = $this->session->get('game');
        if (null === $game) {
            return Response::forRedirectTo('/');
        }

        $params = ['game' => $game];

        return new Response(
            Response::HTTP_OK,
            $this->templateEngine->render('game', $params)
        );
    }
}
