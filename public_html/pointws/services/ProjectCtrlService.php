<?php

include ('Service.php');

class ProjectCtrlService extends Service {

    public function includeSpecificFiles() {

    }

    public function setTasksToSprint() {
        if (checkParams('tasks', 'sprint_id')) {
            $tasks = json_decode($_REQUEST['tasks']);
            $sprint_id = $_REQUEST['sprint_id'];
            if ($sprint_id == '0') {
                $sprint_id = "NULL";
            }
            $conditional = "";
            $comma = true;
            foreach ($tasks as $task) {
                if (!$comma) {
                    $conditional .= " OR ";
                } else {
                    $comma = false;
                }
                $conditional .= " task_id = '$task' ";
            }
            return MysqlDBC::getInstance()->update("UPDATE task SET sprint_id='$sprint_id' WHERE $conditional");
        } else {
            return getErrorArray(03, "Parameters missing (tasks, sprint_id)");
        }
    }

}

new ProjectCtrlService();
?>