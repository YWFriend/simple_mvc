<?php

class TasksModel extends Model
{
    public function getTasks()
    {
        $sql = "SELECT
        t.id,
        t.title,
        DATE_FORMAT(t.timestamp, '%d.%m.%Y %H:%m:%s') as timestamp,
        u.name AS user_name
        FROM
        tasks t
        INNER JOIN
        users AS u ON t.user_id = u.id
        ORDER BY t.timestamp DESC";

        $this->_setSql($sql);
        $tasks = $this->getAll();

        if (empty($tasks))
        {
            return false;
        }

        return $tasks;
    }

    public function getTaskById($id)
    {
        $sql = "SELECT
        t.id,
        t.title,
        t.text,
        DATE_FORMAT(t.datetime, '%d.%m.%Y %H:%m:%s') as datetime,
        DATE_FORMAT(t.timestamp, '%d.%m.%Y %H:%m:%s') as timestamp,
        u.user_name
        FROM
        tasks t
        INNER JOIN
        users AS u ON t.user_id = u.id
        WHERE
        t.id = ?";

        $this->_setSql($sql);
        $articleDetails = $this->getRow(array($id));

        if (empty($articleDetails))
        {
            return false;
        }

        return $articleDetails;
    }
}