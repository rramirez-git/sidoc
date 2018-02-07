<?php
class MyMetas {
	private $postid;
	private $metas;
	public function __construct( $post_id = 0 ){
		$this->setPostId( $post_id );
	}
	public function getPostId() {
		return $this->postid;
	}
	public function setPostId( $valor ) {
		$this->metas = array();
		if( is_numeric( $valor ) && intval( $valor ) > 0 ) {
			$this->postid = $valor;
			$this->metas = get_post_custom( $this->postid );
		} else {
			$this->postid = 0;
		}
		return $this;
	}
	public function getMeta( $key, $asArray = false ) {
		if( count( $this->metas ) && isset( $this->metas[ $key ] ) ) {
			if( $asArray ) {
				return $this->metas[ $key ];
			} else {
				return $this->metas[ $key ][ 0 ];
			}
		}
		return "";
	}
}

function CreateGUID() {
	return sha1( time() );
}

function IMGX_GetRandomUsrInfo() {
	$data = wp_remote_get( 'https://randomuser.me/api/' );
	return ( isset( $data[ "response" ] ) && isset( $data[ "response" ][ "code"] ) && 
		200 <= $data[ "response" ][ "code"] && $data[ "response" ][ "code"] <= 299 &&
		isset( $data[ "body" ] )
		? json_decode( $data[ "body" ], true )[ "results" ][ 0 ] : null );
}


?>
