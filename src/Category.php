<?php

    require_once "Task.php";

    class Category {
        private $category_name;
        private $id;

        function __construct($category_name, $id = null) {
            $this->category_name = $category_name;
            $this->id = $id;
        }

        function setCategoryName($new_category_name) {
            $this->category_name = (string) $new_category_name;
        }

        function getCategoryName() {
            return $this->category_name;
        }

        function getId() {
            return $this->id;
        }

        function getTasks() {
            $query = $GLOBALS['DB']->query("SELECT task_id FROM tasks_categories WHERE category_id = {$this->getId()};");
            $task_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $tasks = Array();
            foreach($task_ids as $id) {
                $task_id = $id['task_id'];
                $result = $GLOBALS['DB']->query("SELECT * FROM tasks WHERE id = {$task_id};");
                $returned_task = $result->fetchAll(PDO::FETCH_ASSOC);

                $task_name = $returned_task[0]['task_name'];
                $id = $returned_task[0]['id'];
                $due_date = $returned_task[0]['due_date'];
                $new_task = new Task($task_name, $id, $due_date);
                array_push($tasks, $new_task);
            }
            return $tasks;
        }

        function save() {
            $GLOBALS['DB']->exec("INSERT INTO categories (category_name) VALUES ('{$this->getCategoryName()}')");
            $this->id = $GLOBALS['DB']->lastInsertId();

        }

        function update($new_category_name) {
            $GLOBALS['DB']->exec("UPDATE categories set category_name = '{$new_category_name}' WHERE id = {$this->getId()};");
            $this->setCategoryName($new_category_name);
        }

        function deleteOne()
        {
            $GLOBALS['DB']->exec("DELETE FROM categories WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM tasks_categories WHERE category_id = {$this->getId()};");
        }

        function addTask($task) {
            $GLOBALS['DB']->exec("INSERT INTO tasks_categories (category_id, task_id) VALUES ({$this->getId()}, {$task->getId()});");
        }

        static function getAll() {
            $returned_categories = $GLOBALS['DB']->query("SELECT * FROM categories;");
            $categories = array();
            foreach($returned_categories as $category) {
                $category_name = $category['category_name'];
                $id = $category['id'];
                $new_category = new Category($category_name, $id);
                array_push($categories, $new_category);
            }
            return $categories;

        }

        static function deleteAll() {
            $GLOBALS['DB']->exec("DELETE FROM categories;");
        }


        static function find($search_id){
            $found_category = null;
            $categories = Category::getAll();
            foreach($categories as $category) {
                $category_id = $category->getId();
                if ($category_id == $search_id) {
                    $found_category = $category;
                }
            }
            return $found_category;
        }

    }




?>
