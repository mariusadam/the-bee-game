<?php

declare(strict_types=1);

namespace BeeGame\Controller;

use BeeGame\Http\ControllerInterface;
use BeeGame\Http\Request;
use BeeGame\Http\Response;
use BeeGame\Templating\TemplateEngineInterface;

class HomepageController implements ControllerInterface
{
    private TemplateEngineInterface $templateEngine;

    public function __construct(TemplateEngineInterface $templateEngine)
    {
        $this->templateEngine = $templateEngine;
    }

    public function __invoke(Request $request): Response
    {
        $params = [];

        return new Response(
            Response::HTTP_OK,
            $this->templateEngine->render('homepage', $params)
        );
    }
}