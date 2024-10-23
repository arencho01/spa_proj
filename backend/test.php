<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username'])) {
        $name = $_POST['username'];

        if ($name) echo $name;
        else return false;
    } else {
        return false;
    }

}
else {
    return false;
}