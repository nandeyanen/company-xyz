<?php

session_start();
// $_SESSION['id']=4
session_unset();
// $_SESSION['id']=null
session_destroy();
// $_SESSION['id']=[]

header("location: ../views");
exit;
