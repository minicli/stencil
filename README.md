# Stencil

> **/ˈstɛns(ə)l/** (noun): 
a thin sheet of card, plastic, or metal with a pattern or letters cut out of it, used to produce the cut design on the surface below by the application of ink or paint through the holes.

**Minicli/Stencil** is a dummy content replacer useful for generating templates. 

Stencils are like lightweight templates with no advanced functionality (so it's not an engine). It simply replaces placeholders with content set up in a string-indexed array or dictionary.

If you are looking for a templating system for front-end views, this is not it! Go check [Twig](https://twig.symfony.com/). Stencil is useful for generating skeleton content (such as to auto-generate classes, Markdown docs and other files following a certain structure).

## Usage

Install Stencil via Composer:

```shell
composer require minicli/stencil
```

Set up a directory within your project to hold your stencils:

```shell
mkdir stencils
cd stencils
```

Create a new `.tpl` file with some variables:

```shell
#stencils/mytemplate.tpl

## This is my Template

My name is {{ name }} and I am a {{ description }}.
```

From your project, instantiate a new Stencil, passing along the stencils directory you set up. Then, call the `applyTemplate` method with an array containing your values:

```php
<?php

$stencil = new Stencil(__DIR__ . '/stencils');

$values = [
    'name' => 'Stencil',
    'description' => 'minimalist, dummy template generator.'
];

$parsedContent = $stencil->applyTemplate('mytemplate', $values);
var_dump($parsedContent);
```
```shell
string(92) "## This is my Template

My name is Stencil and I am a minimalist, dummy template generator.."
```
## Dependencies
Stencil has only testing dependencies.