<?php

require_once("classe_friend.php");
require_once("classe_like.php");

$Friend = new Friend();
//$Friend->get_friend_list(2,2,6);
//$Friend->search_friend(0,1,'julie');

$Like = new Like();
$Like->like_publication(8,1);
$Like->like_comment(8,1);

?>