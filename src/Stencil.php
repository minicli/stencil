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
        $template = $this->getTemplate($templateName);
        foreach ($variables as $variableName => $variableValue) {
            $template = str_replace("{{ $variableName }}", $variableValue, $template);
        }

        return $template;
    }

    /**
     * @param string $templateName
     * @return mixed
     * @throws FileNotFoundException
     */
    public function scanTemplateVars(string $templateName): array
    {
        $template = $this->getTemplate($templateName);
        preg_match_all('/\{\{\s([a-zA-z0-9-_]*\b)\s}}/', $template, $out);
        return $out[1];
    }

    /**
     * @param string $template
     * @return string
     * @throws FileNotFoundException
     */
    public function getTemplate(string $template): string
    {
        $templateFile = $this->stencilDir . '/' . $template . '.tpl';

        if (!is_file($templateFile)) {
            throw new FileNotFoundException("Template file not found.");
        }

        return file_get_contents($templateFile);
    }
}
