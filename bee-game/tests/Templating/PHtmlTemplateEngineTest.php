<?php

declare(strict_types=1);

namespace Tests\Templating;

use BeeGame\Templating\PHtmlTemplateEngine;
use PHPUnit\Framework\TestCase;

class PHtmlTemplateEngineTest extends TestCase
{
    private PHtmlTemplateEngine $templateEngine;

    public function testRender(): void
    {
        $expectedOutput = <<<EXPECTED_OUTPUT
This is a test template.

Param "testValue" has value "&lt;tag&gt;This is a test&lt;/tag&gt;"
EXPECTED_OUTPUT;

        $params = ['testValue' => '<tag>This is a test</tag>'];
        self::assertSame($expectedOutput, $this->templateEngine->render('test-template', $params));
    }

    protected function setUp(): void
    {
        $this->templateEngine = new PHtmlTemplateEngine(
            __DIR__.'/fixtures/'
        );
    }
}
