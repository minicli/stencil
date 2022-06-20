<?php

namespace Minicli;

class Stencil
{
    public string $stencilDir;

    public function __construct(string $stencilDir)
    {
        $this->stencilDir = $stencilDir;
    }

    /**
     * @throws FileNotFoundException
     */
    public function applyTemplate(string $templateName, array $variables = []): string
    {
        $templateFile = $this->stencilDir . '/' . $templateName . '.tpl';

        if (!is_file($templateFile)) {
            throw new FileNotFoundException("Template file not found.");
        }

        $template = file_get_contents($templateFile);

        foreach ($variables as $variableName => $variableValue) {
            $template = str_replace("{{ $variableName }}", $variableValue, $template);
        }

        return $template;
    }
}
