<?php

namespace Php\Project\Gendiff;

use Docopt;

function run(): void
{
    $doc = <<<DOC
    Generate diff

    Usage:
      gendiff (-h|--help)
      gendiff (-v|--version)

    Options:
      -h --help        Show this screen
      -v --version     Show version

    DOC;

    $args = Docopt::handle($doc, ['version' => 'gendiff 1.0']);

    print_r($args);
}
