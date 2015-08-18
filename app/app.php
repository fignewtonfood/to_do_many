<?php
  require_once __DIR__."/../vendor/autoload.php";
  require_once __DIR__."/../src/Task.php";
  require_once __DIR__."/../src/Category.php";

  $app = new Silex\Application();
  $app['debug'] = true;

  $server = 'mysql:host=localhost;dbname=to_do';
  $username = 'root';
  $password = 'root';
  $DB = new PDO($server, $username, $password);

  $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
));

  $app->get("/", function() use ($app) {

    return $app['twig']->render('index.html.twig');

  });

  $app->get("/tasks", function() use ($app) {
      return $app['twig']->render('tasks.html.twig', array('tasks' => Task::getAll(), 'categories' => Category::getAll()));
  });

  $app->get("/categories", function() use ($app) {
      Task::deleteAll();
      return $app['twig']->render('categories.html.twig', array('categories' => Category::getAll()));
  });

  $app->post("/categories", function() use ($app) {
      $category = new Category($_POST['name']);
      $category->save();
      return $app['twig']->render('categories.html.twig', array('categories' => Category::getAll()));
  });

  $app->post("/tasks", function () use ($app) {
      $id = null;
      $category_id = intval($_POST['category_id']);
      $category_name = Category::find($category_id);
      $task = new Task($_POST['description'], $id, $_POST['due_date'], $category_id);
      $task->save();
      return $app['twig']->render('tasks.html.twig', array('tasks' => Task::getAll(), 'categories' => Category::getAll(), 'category_name' => $category_name));
  });

  $app->post("/delete_tasks", function() use ($app) {
      Task::deleteAll();
      return $app['twig']->render('index.html.twig');
  });

  $app->post("/delete_categories", function() use ($app) {
      Category::deleteAll();
      return $app['twig']->render('index.html.twig');
  });

  return $app;
?>
