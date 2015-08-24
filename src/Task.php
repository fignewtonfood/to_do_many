<?php
class Task
{
    private $task_name;
    private $id;
    private $due_date;

    function __construct($task_name, $id = null, $due_date)
    {
        $this->task_name = $task_name;
        $this->id = $id;
        $this->due_date = $due_date;
    }

    function setTaskName($new_task_name)
    {
        $this->task_name = (string) $new_task_name;
    }

    function getTaskName()
    {
        return $this->task_name;
    }

    function getId()
    {
        return $this->id;
    }

    function getDueDate() {
        return $this->due_date;
    }

    function save()
    {
        $statement = $GLOBALS['DB']->exec("INSERT INTO tasks (task_name, due_date) VALUES ('{$this->getTaskName()}', '{$this->getDueDate()}')");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    function update($new_task_name) {
        $GLOBALS['DB']->exec("UPDATE tasks SET task_name = '{$new_task_name}' WHERE id = {$this->getId()};");
        $this->setTaskName($new_task_name);
    }

    function deleteOne() {
        $GLOBALS['DB']->exec("DELETE FROM tasks WHERE id = {$this->getId()};");
        $GLOBALS['DB']->exec("DELETE FROM tasks_categories WHERE task_id = {$this->getId()};");
    }

    function addCategory($category)
    {
        $GLOBALS['DB']->exec("INSERT INTO tasks_categories (task_id, category_id) VALUES ({$this->getId()}, {$category->getId()});");
    }

    function getCategories()
    {
        $query = $GLOBALS['DB']->query("SELECT category_id FROM tasks_categories WHERE task_id={$this->getId()};");
        $category_ids = $query->fetchAll(PDO::FETCH_ASSOC);

        $categories = array();
        foreach ($category_ids as $id) {
            $category_id = $id['category_id'];
            $result = $GLOBALS['DB']->query("SELECT * FROM categories WHERE id = {$category_id};");
            $returned_category = $result->fetchAll(PDO::FETCH_ASSOC);

            $category_name = $returned_category[0]['category_name'];
            $id = $returned_category[0]['id'];
            $new_category = new Category($category_name, $id);
            array_push($categories, $new_category);
        }
        return $categories;
    }

    static function getAll()
    {
        $returned_tasks = $GLOBALS['DB']->query("SELECT * FROM tasks ORDER BY due_date;");
        $tasks = array();
        foreach($returned_tasks as $task) {
            $task_name = $task['task_name'];
            $id = $task['id'];
            $due_date = $task['due_date'];
            $new_task = new Task($task_name, $id, $due_date);
            array_push($tasks, $new_task);
        }
        return $tasks;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM tasks;");
    }

    static function find($search_id) {
        $found_task = null;
        $tasks = Task::getAll();
        foreach($tasks as $task) {
            $task_id = $task->getId();
            if ($task_id == $search_id) {
                $found_task = $task;
            }
        }
        return $found_task;
    }

}
?>
