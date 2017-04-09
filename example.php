<?php

include('vendor/autoload.php');

use DirectoryManager\DirectoryManager as DirManager;

//  instantiate DirectoryManager;
$dirm = new DirManager('..');

//  create directory 'test/alphabet'
$dirm->mkdir('testdir/alphabet');

$string = 'abcdefghijklmonpkrstuvwxyz';
$dirs_names = str_split($string, 3);

//  cd to directory created before
$dirm->cd('testdir/alphabet');

//  get file manager - it has the same context as directory manager.
//  optionally set the new context as parameter
$filem = $dirm->getFileManager();

foreach ($dirs_names as $dir_name) {

    $dirm->mkdir($dir_name);
    $dir_name_array = str_split($dir_name, 1);
    $filem->cd($dir_name);

    foreach ($dir_name_array as $char) {
        $f = $filem->mkfile($char . '.txt');
        $f->write("Created at " . date('y-m-d h:i:s') . "\n");
        $f->write($char);
        $f->save();
    }

    $filem->cd('..');

}

