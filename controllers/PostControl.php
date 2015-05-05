<?php

class PostControl
{
	private $params_;

	public function createPost()
	{
		$com = new post();

		return json_encode($com->createComment($this->params_["id_posts"], $this->params_["texte"]));
	}

	public function alterPost()
	{
		$com = new post();

		return json_encode($com->alterComment($this->params_["id_comms"], $this->params_["texte"]));
	}

	public function deletePost()
	{
		$com = new post();

		return json_encode($com->deleteComment($this->params_["id_comms"]));
	}

	public function timelinePost() {
		$com = new post();

		return json_encode($com->timelinePost($this->params_["id_user"], $this->params_["offset"], $params_["limit"]));
	}

}


?>