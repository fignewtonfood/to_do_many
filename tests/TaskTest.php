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
            Category::deleteAll();
        }

        function testGetTaskName() {
            //Arrange
            $task_name = "Do dishes";
            $id = null;
            $due_date = null;
            $test_task = new Task($task_name, $id, $due_date);

            //Act
            $result = $test_task->getTaskName();

            //Assert
            $this->assertEquals($task_name, $result);
        }

        function testSetTaskName() {
            //Arrange
            $task_name = "Do dishes";
            $id = null;
            $due_date = null;
            $test_task = new Task($task_name, $id, $due_date);

            //Act
            $test_task->setTaskName("Drink coffee.");
            $result = $test_task->getTaskName();

            //Assert
            $this->assertEquals("Drink coffee.", $result);
        }


        function test_getId() {

            //Arrange
            $task_name = "Wash the dog";
            $id = 1;
            $due_date = null;
            $test_task = new Task ($task_name, $id, $due_date);

            //Act
            $result = $test_task->getId();

            //Assert
            $this->assertEquals(1, $result);


        }
        //
        // function test_getCategoryId() {
        //     //Arrange
        //     $name = "Home stuff";
        //     $id = null;
        //     $test_category = new Category($name, $id);
        //     $test_category->save();
        //
        //     $task_name = "Wash the dog";
        //     $due_date = "2015-08-22";
        //     $category_id = $test_category->getId();
        //     $test_task = new Task($task_name, $id, $due_date, $category_id);
        //     $test_task->save();
        //
        //     //Act
        //     $result = $test_task->getCategoryId();
        //
        //     //Assert
        //     $this->assertEquals(true, is_numeric($result));
        // }
        //
        // function test_getDueDate() {
        //     //Arrange
        //     $name = "Home stuff";
        //     $id = null;
        //     $test_category = new Category($name, $id);
        //     $test_category->save();
        //
        //     $task_name = "Wash the dog";
        //     $due_date = "2015-08-22";
        //     $category_id = $test_category->getId();
        //     $test_task = new Task($task_name, $id, $due_date, $category_id);
        //     $test_task->save();
        //
        //     //Act
        //     $result = $test_task->getDueDate();
        //
        //     //Assert
        //     $this->assertEquals($result, "2015-08-22");
        // }
        //
        function test_save() {
            //Arrange
            $task_name = "Wash the dog";
            $id = 1;
            $due_date = null;
            $test_task = new Task($task_name, $id, $due_date);

            //Act
            $test_task->save();

            //Assert
            $result = Task::getAll();
            $this->assertEquals($test_task, $result[0]);

        }

        function testSaveSetsId () {
            //Arrange
            $task_name = "Wash the dog";
            $id = 1;
            $due_date = null;
            $test_task = new Task ($task_name, $id, $due_date);

            //Act
            $test_task->save();

            //Assert
            $this->assertEquals(true, is_numeric($test_task->getId()));
        }

        function test_getAll() {
            //Arrange
            $task_name = "Wash the dog";
            $due_date = "2015-08-22";
            $id = 1;
            $test_Task = new Task($task_name, $id, $due_date);
            $test_Task->save();

            $task_name2 = "Water the lawn";
            $due_date2 = "2015-08-24";
            $id2 = 2;
            $test_Task2 = new Task($task_name2, $id2, $due_date2);
            $test_Task2->save();

            //Act
            $result = Task::getAll();

            //Assert
            $this->assertEquals([$test_Task, $test_Task2], $result);

        }

        function test_deleteAll() {

            //Arrange
            $task_name = "Wash the dog";
            $due_date = "2015-08-25";
            $id = 1;
            $test_Task = new Task($task_name, $id, $due_date);
            $test_Task->save();

            $task_name2 = "Water the lawn";
            $due_date2 = "2015-08-22";
            $id2 = 2;
            $test_Task2 = new Task($task_name2, $id2, $due_date2);
            $test_Task2->save();

            //Act
            Task::deleteAll();

            //Assert
            $result = Task::getAll();
            $this->assertEquals([], $result);


        }

        function test_find() {
            //Arrange
            $task_name = "Wash the dog";
            $due_date = "2015-08-22";
            $id1=1;
            $test_Task = new Task($task_name, $id1, $due_date);
            $test_Task->save();

            $task_name2 = "Water the lawn";
            $due_date2 = "2015-08-25";
            $id2 = 2;
            $test_Task2 = new Task($task_name2, $id2, $due_date2);
            $test_Task2->save();

            //Act
            $id = $test_Task->getId();
            $result = Task::find($id);

            //Assert
            $this->assertEquals($test_Task, $result);
        }

        function testUpdate() {
            //Arrange
            $task_name = "Wash the dog";
            $id = 1;
            $due_date = null;
            $test_task = new Task($task_name, $id, $due_date);
            $test_task->save();

            $new_task_name = "Clean the dog";

            //Act
            $test_task->update($new_task_name);

            //Assert
            $this->assertEquals("Clean the dog", $test_task->getTaskName());
        }
        //
        // function test_sort() {
        //     //Arrange
        //     $name = "Home stuff";
        //     $id = null;
        //     $test_category = new Category($name, $id);
        //     $test_category->save();
        //
        //     $task_name = "Wash the dog2";
        //     $due_date = "2015-08-25";
        //     $category_id = $test_category->getId();
        //     $test_Task = new Task($task_name, $id, $due_date, $category_id);
        //     $test_Task->save();
        //
        //     $task_name2 = "Water the lawn1";
        //     $due_date2 = "2015-08-22";
        //     $test_Task2 = new Task($task_name2, $id, $due_date2, $category_id);
        //     $test_Task2->save();
        //
        //     $task_name3 = "Wash the dog3";
        //     $due_date3 = "2015-08-28";
        //     $test_Task3 = new Task($task_name, $id, $due_date3, $category_id);
        //     $test_Task3->save();
        //
        //     //Act
        //     $id = $test_Task->getId();
        //     $result = Task::getAll();
        //
        //
        //     //Assert
        //     $this->assertEquals([$test_Task2, $test_Task, $test_Task3], $result);
        // }

        function testDeleteTask() {
            //Arrange
            $task_name = "Wash the dog";
            $id = 1;
            $due_date = null;
            $test_task = new Task($task_name, $id, $due_date);
            $test_task->save();

            $task_name2 = "Water the lawn";
            $id2 = 2;
            $due_date2 = null;
            $test_task2 = new Task($task_name2, $id2, $due_date2);
            $test_task2->save();

            //Act
            $test_task->deleteOne();

            //Assert
            $this->assertEquals([$test_task2], Task::getAll());
        }

        function testAddCategory()
        {
            //Arrange
            $category_name = "Work stuff";
            $id = 1;
            $test_category = new Category($category_name, $id);
            $test_category->save();

            $task_name = "File reports";
            $id2 = 2;
            $due_date = null;
            $test_task = new Task($task_name, $id2, $due_date);
            $test_task->save();

            //Act
            $test_task->addCategory($test_category);

            //Assert
            $this->assertEquals($test_task->getCategories(), [$test_category]);
        }

        function testGetCategories()
        {
            //Arrange
            $category_name = "Work stuff";
            $id = 1;
            $test_category = new Category($category_name, $id);
            $test_category->save();

            $category_name2 = "Volunteer stuff";
            $id2 = 2;
            $test_category2 = new Category($category_name2, $id2);
            $test_category2->save();

            $task_name = "File reports";
            $id3 = 3;
            $due_date = null;
            $test_task = new Task($task_name, $id3, $due_date);
            $test_task->save();

            //Act
            $test_task->addCategory($test_category);
            $test_task->addCategory($test_category2);

            //Assert
            $this->assertEquals($test_task->getCategories(), [$test_category, $test_category2]);
        }

        function testDelete() {
            //Arrange
            $category_name = "Work stuff";
            $id = 1;
            $test_category = new Category($category_name, $id);
            $test_category->save();

            $task_name = "File reports";
            $id2 = 2;
            $due_date = null;
            $test_task = new Task($task_name, $id2, $due_date);
            $test_task->save();

            //Act
            $test_task->addCategory($test_category);
            $test_task->deleteOne();

            //Assert
            $this->assertEquals([], $test_category->getTasks());
        }

    }
?>
