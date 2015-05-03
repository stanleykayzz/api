<?php
	class FriendControl {
		//request POST or GET
		private $params_;
		
		public function __construct($params) {
			$this->params_ = $params;
		}

		public function askFriend($id,$id_friend)
		{
			$friend = new Friend();
			return json_encode($friend->ask_friend_resquest($params_["id"],$params_["id_friend"]);
		}

		public function answerFriend($answer,$id,$id_friend)
		{
			$friend = new Friend();
			return json_encode($friend->answer_friend_resquest($params_["answer"],$params_["id"],$params_["id_friend"]);
		}

		public function delFriend($id,$id_friend)
		{
			$friend = new Friend();
			return json_encode($friend->del_friend($params_["id"],$params_["id_friend"]);
		}

		public function cancelFriend($id,$id_friend)
		{
			$friend = new Friend();
			return json_encode($friend->cancel_friend_request($params_["id"],$params_["id_friend"]);
		}

		public function getlistFriend($offset,$limit,$id_user)
		{
			$friend = new Friend();
			return json_encode($friend->get_friend_list($params_["offset"],$params_["limit"],$params_["id_user"]);
		}
	}
?>