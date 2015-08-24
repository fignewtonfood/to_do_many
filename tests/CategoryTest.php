<?php


    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Category.php";
    require_once "src/Task.php";

    $server = 'mysql:host=localhost;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CategoryTest extends PHPUnit_Framework_TestCase {


        protected function tearDown() {
            Category::deleteAll();
            Task::deleteAll();
        }

        function test_getCategoryName() {

            //Arrange
            $category_name = "Work stuff";
            $test_Category = new Category($category_name);

            //Act
            $result = $test_Category->getCategoryName();

            //Assert
            $this->assertEquals($category_name, $result);
        }

        function testSetCategoryName()
        {
            //Arrange
            $category_name = "Kitchen chores";
            $test_category = new Category($category_name);

            //Act
            $test_category->setCategoryName("Home chores");
            $result = $test_category->getCategoryName();

            //Assert
            $this->assertEquals("Home chores", $result);
        }

        function test_getId() {
            //Arrange
            $category_name = "Work stuff";
            $id = 1;
            $test_category = new Category($category_name, $id);

            //Act
            $result = $test_category->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        function test_save() {
            //Arrange
            $category_name = "Work stuff";
            $id = 1;
            $test_category = new Category($category_name, $id);
            $test_category->save();

            //Act
            $result = Category::getAll();

            //Assert
            $this->assertEquals($test_category, $result[0]);
        }

        function testUpdate () {
            //Arrange
            $category_name = "Work stuff";
            $id = 1;
            $test_category = new Category($category_name, $id);
            $test_category->save();

            $new_category_name = "Home stuff";

            //Act
            $test_category->update($new_category_name);

            //Assert
            $this->assertEquals("Home stuff", $test_category->getCategoryName());
        }

        function testDeleteCategory()
        {
            //Arrange
            $category_name = "Work stuff";
            $id = 1;
            $test_category = new Category($category_name, $id);
            $test_category->save();

            $category_name2 = "Home stuff";
            $id2 = 2;
            $test_category2 = new Category($category_name2, $id2);
            $test_category2->save();


            //Act
            $test_category->deleteOne();

            //Assert
            $this->assertEquals([$test_category2], Category::getAll());
        }

        function test_getAll() {

            //Arrange
            $category_name = "Work stuff";
            $category_name2 = "Home stuff";
            $id = 1;
            $id2 = 2;
            $test_category = new Category($category_name, $id);
            $test_category->save();
            $test_category2 = new Category($category_name2, $id2);
            $test_category2->save();

            //Act
            $result = Category::getAll();

            //Assert
            $this->assertEquals([$test_category, $test_category2], $result);
        }

        function test_deleteAll() {
            //Arrange
            $category_name = "Wash the dog";
            $id1 = 1;
            $category_name2 = "Home stuff";
            $id2 = 2;
            $test_category = new Category($category_name, $id1);
            $test_category->save();
            $test_category2 = new Category($category_name2, $id2);
            $test_category2->save();

            //Act
            Category::deleteAll();
            $result = Category::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find() {

            //Arrange
            $category_name = "Wash the dog";
            $id1 = 1;
            $category_name2 = "Home stuff";
            $id2 = 2;
            $test_category = new Category($category_name, $id1);
            $test_category->save();
            $test_category2 = new Category($category_name2, $id2);
            $test_category2->save();

            //Act
            $result = Category::find($test_category->getId());

            //Assert
            $this->assertEquals($test_category, $result);
        }

        function testAddTask() {
            //Arrange
            $category_name = "Work stuff";
            $id1 = 1;
            $test_category = new Category($category_name, $id1);
            $test_category->save();

            $task_name = "File reports";
            $id2 = 2;
            $due_date = null;
            $test_task = new Task($task_name, $id2, $due_date);
            $test_task->save();

            //Act
            $test_category->addTask($test_task);

            //Assert
            $this->assertEquals($test_category->getTasks(), [$test_task]);
        }

        function testGetTasks() {
            //Arrange
            $category_name = "Home stuff";
            $id1 = 1;
            $test_category = new Category($category_name, $id1);
            $test_category->save();

            $task_name = "Wash the dog";
            $id2 = 2;
            $due_date = null;
            $test_task = new Task($task_name, $id2, $due_date);
            $test_task->save();

            $task_name2 = "Take out the trash";
            $id3 = 3;
            $test_task2 = new Task($task_name2, $id3, $due_date);
            $test_task2->save();

            //Act
            $test_category->addTask($test_task);
            $test_category->addTask($test_task2);

            //Assert
            $this->assertEquals($test_category->getTasks(), [$test_task, $test_task2]);
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
            $test_category->addTask($test_task);
            $test_category->deleteOne();

            //Assert
            $this->assertEquals([], $test_task->getCategories());
        }


    }

?>
