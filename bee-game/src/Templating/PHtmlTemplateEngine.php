<?php

declare(strict_types=1);

namespace BeeGame\Templating;

/**
 * Engine that renders php html templates
 */
class PHtmlTemplateEngine implements TemplateEngineInterface
{
    private string $templatesDir;

    public function __construct(string $templatesDir)
    {
        $this->templatesDir = $templatesDir;
    }

    public function render(string $templateName, array $params): string
    {
        $templateFile = sprintf('%s/%s.phtml', $this->templatesDir, $templateName);

        return $this->doRender($templateFile, $params);
    }

    private function doRender(string $templateFile, array $params): string
    {
        ob_start();
        require $templateFile;

        return ob_get_clean();
    }

    private function escape(string $value): void
    {
        echo htmlspecialchars($value);
    }
}
