<?php

class CommentControl
{
	private $params_;

	public function createComment()
	{
		$com = new comment();

		return json_encode($com->createComment($this->params_["id_comms"], $this->params_["texte"]));
	}

	public function alterComment()
	{
		$com = new comment();

		return json_encode($com->alterComment($this->params_["id_comms"], $this->params_["texte"]));
	}

	public function deleteComment()
	{
		$com = new comment();

		return json_encode($com->deleteComment($this->params_["id_comms"]));
	}

}

?>
