<?php

use Minicli\FileNotFoundException;

it('sets the template dir', function () {
    $stencil = getStencil();
    expect($stencil->stencilDir)->toBeString();
});

it('falls back to secondary tpl dir when tpl not found in default location', function () {
    $stencil = getStencil();
    $parsedContent = $stencil->applyTemplate('othertemplate', []);
    expect($parsedContent)->toBeString();
    $this->assertStringContainsString("This is my Other Template", $parsedContent);
});

it('throws exception if template not found', function () {
    $stencil = getStencil();
    $this->expectException(FileNotFoundException::class);
    $stencil->applyTemplate('notfound', []);
});

it('parses template', function () {
    $stencil = getStencil();
    $values = [
        'name' => 'Stencil',
        'description' => 'minimalist, dummy template generator.'
    ];

    $parsedContent = $stencil->applyTemplate('mytemplate', $values);

    expect($parsedContent)->toBeString();
    $this->assertStringContainsString($values['name'], $parsedContent);
    $this->assertStringContainsString($values['description'], $parsedContent);
});

it('obtains list of template variables', function () {
    $stencil = getStencil();
    $variables = $stencil->scanTemplateVars('mytemplate');

    expect($variables)
        ->toBeArray()
        ->toContain('name')
        ->toContain('description');
});
