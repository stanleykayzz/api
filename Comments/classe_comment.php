<?php
	class Comment {
		private $text_;
		private $post_;
		
		public function __construct($text=NULL, $post=NULL) {
			$this->text_ = $text;
			$this->post_ = $post;
		}
		
		public function __construct($post=NULL) {
			$this->text_ = $text;
			$this->post_ = $post;
		}
		
		public function setText($text) {
			$this->text_ = $text;
		}
		
		public function getText() {
			return $this->text_;
		}
		
		public function setPost($post) {
			$this->post_ = $post;
		}
		
		public function getPost() {
			return $this->id_com_;
		}
	}
?>