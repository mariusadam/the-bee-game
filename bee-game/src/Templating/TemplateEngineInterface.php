<?php

declare(strict_types=1);

namespace BeeGame\Templating;

interface TemplateEngineInterface
{
    public function render(string $templateName, array $params): string;
}
