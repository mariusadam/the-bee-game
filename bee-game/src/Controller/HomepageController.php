<?php

declare(strict_types=1);

namespace BeeGame\Controller;

use BeeGame\Http\ControllerInterface;
use BeeGame\Http\Request;
use BeeGame\Http\Response;
use BeeGame\Http\Session;
use BeeGame\Templating\TemplateEngineInterface;

class HomepageController implements ControllerInterface
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
        if (null !== $this->session->get('game')) {
            return Response::forRedirectTo('/play');
        }

        return new Response(
            Response::HTTP_OK,
            $this->templateEngine->render('homepage', [])
        );
    }
}
