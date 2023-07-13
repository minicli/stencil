<?php

namespace Minicli;

class Stencil
{
    public string $stencilDir;
    public array $fallbackDirs = [];

    public function __construct(string $stencilDir)
    {
        $this->stencilDir = $stencilDir;
    }

    /**
     * Additional template dirs to look for
     * @param array $fallbackDirs
     * @return void
     */
    public function fallbackTo(array $fallbackDirs)
    {
        $this->fallbackDirs = $fallbackDirs;
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
            $templateFile = $this->locateFallbackTemplate($template);
        }

        return file_get_contents($templateFile);
    }

    public function locateFallbackTemplate(string $template): string
    {
        foreach ($this->fallbackDirs as $fallbackDir) {
            $templateFile = $fallbackDir . '/' . $template . '.tpl';
            if (is_file($templateFile)) {
                return $templateFile;
            }
        }

        throw new FileNotFoundException("Template file not found.");
    }
}
