<?php
	class LikeControl {
		//request POST or GET
		private $params_;
		
		public function __construct($params) {
			$this->params_ = $params;
		}
		
		public function postLike() {
			$Like = new Like();
			return json_encode($Like->like_publication($this->params_["id_user"],$this->params_["id_post"]));
		}
		
		public function comLike() {
			$Like = new Like();
			return json_encode($Like->like_comment($this->params_["id_user"],$this->params_["id_com"]));
		}
		
	}
?>