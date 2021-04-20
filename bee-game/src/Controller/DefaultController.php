<?php

declare(strict_types=1);

namespace BeeGame\Controller;

use BeeGame\Http\ControllerInterface;
use BeeGame\Http\Request;
use BeeGame\Http\Response;
use BeeGame\Templating\TemplateEngineInterface;

class DefaultController implements ControllerInterface
{
    private TemplateEngineInterface $templateEngine;

    public function __construct(TemplateEngineInterface $templateEngine)
    {
        $this->templateEngine = $templateEngine;
    }

    public function __invoke(Request $request): Response
    {
        $body = $this->templateEngine->render('not-found', ['request' => $request]);

        return new Response(404, $body);
    }
}
