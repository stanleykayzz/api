<?php
	class FriendControl {
		//request POST or GET
		private $params_;
		
		public function __construct($params) {
			$this->params_ = $params;
		}

		public function askFriend()
		{
			$friend = new Friend();
			return json_encode($friend->ask_friend_resquest($this->params_["id"],$this->params_["id_friend"]));
		}

		public function answerFriend()
		{
			$friend = new Friend();
			return json_encode($friend->answer_friend_resquest($this->params_["answer"],$this->params_["id"],$this->params_["id_friend"]));
		}

		public function delFriend()
		{
			$friend = new Friend();
			return json_encode($friend->del_friend($this->params_["id"],$this->params_["id_friend"]));
		}

		public function cancelFriend()
		{
			$friend = new Friend();
			return json_encode($friend->cancel_friend_request($this->params_["id"],$this->params_["id_friend"]));
		}

		public function getlistFriend()
		{
			$friend = new Friend();
			return json_encode($friend->get_friend_list($this->params_["offset"],$this->params_["limit"],$this->params_["id_user"]));
		}

		public function searchFriend() {
			$friend = new Friend();
			return json_encode($friend->search_friend($this->params_["offset"], $this->params_["limit"], $this->params_["id_user"], $this->params_["$name"]));
		}

		public function getmostpostFriend() {
			$friend = new Friend();
			return json_encode($friend->get_list_user_most_post($this->params_["offset"], $this->params_["limit"], $this->params_["id_user"]));
		}
	}
?>