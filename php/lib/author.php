<?php
// require once your autoload.php
// use the use keyword to specify the namespace you want to use
// make sure to stay loyal to the constructor.
//var_dump the object

namespace Nmora9\Author;

require_once(dirname(__DIR__, 1) . "/Classes/Author.php");


use Ramsey\Uuid\Uuid;

$newAuthorId = new Author("6b3eadae-c9c3-4f69-a89c-7501ccfa6d65", "hehehehehehehehehehehehehehehe",
"www.avatarwebsite.com", "nehomahm@gmail.com","nanananananananananananananananananananananananananananananananananananananananananananananananan",
"Brilliant Writer");
var_dump($newAuthorId);