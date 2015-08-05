<?php
  require_once __DIR__."/../vendor/autoload.php";
  require_once __DIR__."/../src/Task.php";

  $app = new Silex\Application();

  $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
));

  $app->get("/", function() {
    $output = "";
    foreach ($list_of_tasks as $task) {
    $output = $output . "<p>" . $task->getDescription() . "</p>";
    
    return $app['twig']->render('tasks.twig');
}
  });

  return $app;
?>
