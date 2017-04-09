<?php

include('vendor/autoload.php');

use DirectoryManager\DirectoryManager as DirManager;

$dirm = DirManager::setup('..');

$f = $dirm->getFileManager()->rmfile('test.php');
