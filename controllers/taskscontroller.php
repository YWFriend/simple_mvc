<?php

class TasksController extends Controller
{
    public function __construct($model, $action)
    {
        parent::__construct($model, $action);
        $this->_setModel($model);
    }

    public function index()
    {
        try 
        {
            $tasks = $this->_model->getTasks();
            $this->_view->set('tasks', $tasks);
            $this->_view->set('title', 'All tasks from the database');
            print_r($_SESSION);
            return $this->_view->output();
            

        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }
}