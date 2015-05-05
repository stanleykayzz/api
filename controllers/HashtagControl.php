<?php
	class HashtagControl {
		private $params_;
		
		public function __construct($params) {
			$this->params_ = $params;
		}

		public createHashtag() {
			$hash = new Hashtag();
			return json_encode($hash->createHashtag($params_["mot"]));
		}
	}
?>