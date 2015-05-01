<?php
	class hashtag
	{
		//attributs
		private $hashtag_;
		private $keyword_;

		//constructeur		
		public function __construct($keyword)
		{
			$this->keyword = $keysord;
		}
		
		public function setHashtag($hashtag) {
			$this->hashtag_ = $hashtag;
		}
		
		public function getHashtag() {
			return $this->hashtag_;
		}
		
		public function setKeyword($keyword) {
			$this->keyword_ = $keyword;
		}
		
		public function getKeyword() {
			return $this->keyword_;
		}
		
	}
?>