<?php
	class Like_commentControl {
		//request POST or GET
		private $params_;
		
		public function __construct($params) {
			$this->params_ = $params;
		}
		
		public function likeComment() {
			$Like = new Like();
			return json_encode($Like->like_publication($this->params_["id_user"],$this->params_["id_post"]));
		}
		
		public function likePost() {
			$Like = new Like();
			return json_encode($Like->like_publication($this->params_["id_user"],$this->params_["id_post"]));
		}
		
		public function dislikeComment() {
			$Like = new Like();
			return json_encode($Like->like_comment($this->params_["id_user"],$this->params_["id_com"]));
		}

		public function dislikePost() {
			$Like = new Like();
			return json_encode($Like->like_comment($this->params_["id_user"],$this->params_["id_com"]));
		}
		
	}
?>