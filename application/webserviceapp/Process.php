<?php 	 
class Process {


	function __construct(  ) {
		require("conexion.php");
	}

	public function getName() {
		$user = $_POST['userid'];
		//$pass = sha1(md5($_POST['password']));

		$lista=R::find( 'user', "id=".$user );
		$usuario="false";
		if($lista){
			foreach ($lista as $key ) {
				$_SESSION['user_id']=$key['id'] ;
				$usuario=$key;
				break;
			}
		}
		echo $usuario;
		
	}

	function isAdult() {
		
	}

}
?>