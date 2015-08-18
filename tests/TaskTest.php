<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Task.php";

    $server = 'mysql:host=localhost;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);



    class TaskTest extends PHPUnit_Framework_TestCase {


        protected function tearDown() {
            Task::deleteAll();
        }

        function test_getId() {

            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $due_date = "2015-08-22";
            $category_id = $test_category->getId();
            $test_task = new Task($description, $id, $due_date, $category_id);
            $test_task->save();

            //Act
            $result = $test_task->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));


        }

        function test_getCategoryId() {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $due_date = "2015-08-22";
            $category_id = $test_category->getId();
            $test_task = new Task($description, $id, $due_date, $category_id);
            $test_task->save();

            //Act
            $result = $test_task->getCategoryId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_getDueDate() {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $due_date = "2015-08-22";
            $category_id = $test_category->getId();
            $test_task = new Task($description, $id, $due_date, $category_id);
            $test_task->save();

            //Act
            $result = $test_task->getDueDate();

            //Assert
            $this->assertEquals($result, "2015-08-22");
        }

        function test_save() {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $due_date = "2015-08-22";
            $category_id = $test_category->getId();
            $test_task = new Task($description, $id, $due_date, $category_id);

            //Act
            $test_task->save();

            //Assert
            $result = Task::getAll();
            $this->assertEquals($test_task, $result[0]);

        }

        function test_getAll() {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $due_date = "2015-08-22";
            $category_id = $test_category->getId();
            $test_Task = new Task($description, $id, $due_date, $category_id);
            $test_Task->save();

            $description2 = "Water the lawn";
            $due_date2 = "2015-08-24";
            $test_Task2 = new Task($description2, $id, $due_date2, $category_id);
            $test_Task2->save();

            //Act
            $result = Task::getAll();

            //Assert
            $this->assertEquals([$test_Task, $test_Task2], $result);

        }

        function test_deleteAll() {

            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $due_date = "2015-08-25";
            $category_id = $test_category->getId();
            $test_Task = new Task($description, $id, $due_date, $category_id);
            $test_Task->save();

            $description2 = "Water the lawn";
            $due_date2 = "2015-08-22";
            $test_Task2 = new Task($description2, $id, $due_date2, $category_id);
            $test_Task2->save();

            //Act
            Task::deleteAll();

            //Assert
            $result = Task::getAll();
            $this->assertEquals([], $result);


        }

        function test_find() {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $due_date = "2015-08-22";
            $category_id = $test_category->getId();
            $test_Task = new Task($description, $id, $due_date, $category_id);
            $test_Task->save();

            $description2 = "Water the lawn";
            $due_date2 = "2015-08-25";
            $test_Task2 = new Task($description2, $id, $due_date2, $category_id);
            $test_Task2->save();

            //Act
            $id = $test_Task->getId();
            $result = Task::find($id);

            //Assert
            $this->assertEquals($test_Task, $result);
        }

        function test_sort() {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog2";
            $due_date = "2015-08-25";
            $category_id = $test_category->getId();
            $test_Task = new Task($description, $id, $due_date, $category_id);
            $test_Task->save();

            $description2 = "Water the lawn1";
            $due_date2 = "2015-08-22";
            $test_Task2 = new Task($description2, $id, $due_date2, $category_id);
            $test_Task2->save();

            $description3 = "Wash the dog3";
            $due_date3 = "2015-08-28";
            $test_Task3 = new Task($description, $id, $due_date3, $category_id);
            $test_Task3->save();

            //Act
            $id = $test_Task->getId();
            $result = Task::getAll();


            //Assert
            $this->assertEquals([$test_Task2, $test_Task, $test_Task3], $result);
        }

    }
?>
