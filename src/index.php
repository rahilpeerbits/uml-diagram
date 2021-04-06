<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include('../vendor/autoload.php');
putenv('TMPDIR=/var/www/html/digram-test/manual/generated');
use Bartlett\UmlWriter\Generator\GeneratorFactory;
use Bartlett\UmlWriter\Service\ClassDiagramRenderer;
use Symfony\Component\Finder\Finder;

$dataSource = dirname(__DIR__) . '/data_source';
$finder = new Finder();
$finder->in($dataSource)->name('*.php');

// use GraphViz as back-end generator
$generatorFactory = new GeneratorFactory('graphviz');
// creates instance of Bartlett\GraphUml\Generator\GraphVizGenerator
$generator = $generatorFactory->getGenerator();

$renderer = new ClassDiagramRenderer();
// generates UML class diagram of all objects found in dataSource
$script = $renderer($finder, $generator);
// show UML diagram statements
echo $script;

$generator->setFormat('svg');
// default format is PNG
// print_r($renderer->getGraph());
echo $generator->createImageFile($renderer->getGraph()). ' file generated' . PHP_EOL;
