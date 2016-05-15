<?php


Database::instancier();

/****************************************************************************************
**                                                                                     **
**    88888888ba                          88           88                              **
**    88      "8b                         ""    ,d     ""                              **
**    88      ,8P                               88                                     **
**    88aaaaaa8P'  ,adPPYba,   ,adPPYba,  88  MM88MMM  88   ,adPPYba,   8b,dPPYba,     **
**    88""""""'   a8"     "8a  I8[    ""  88    88     88  a8"     "8a  88P'   `"8a    **
**    88          8b       d8   `"Y8ba,   88    88     88  8b       d8  88       88    **
**    88          "8a,   ,a8"  aa    ]8I  88    88,    88  "8a,   ,a8"  88       88    **
**    88           `"YbbdP"'   `"YbbdP"'  88    "Y888  88   `"YbbdP"'   88       88    **
**                                                                                     **
**                                                                                     **
*****************************************************************************************/

class Position {

	static function ajouter($x, $y, $identifiant_jk, $id_lieu){

		$reponse = new stdClass();
		//Vérification des paramètres
		if(intval($x) != $x || intval($y) != $y || strlen($identifiant_jk) == 0 
			|| intval($id_lieu) != $id_lieu){
			$reponse->exception = true;
			$reponse->erreur = "Erreur de paramètres";
			return $reponse;
		}
		//insertion dans la base de données
		$statement = Database::$instance->prepare("INSERT INTO `position`(`x`, `y`, `identifiant_jk`, `id_lieu`, `date`)"
			." VALUES (:x, :y, :identifiant_jk, :id_lieu, :date);");
		$reponse->ajoutOK = $statement->execute(array(":x"             => $x,
													  ':y'             => $y,
													  ':identifiant_jk'=> $identifiant_jk,
													  ':id_lieu'       => $id_lieu,
													  ':date'		   => date("Y-m-d H:i:s")));
		return $reponse;

	}

	static function existe($id){

		$reponse  = new stdClass();
		//Vérification du paramètre en entrée
		if($id == null || $id != intval($id)){
			$reponse->exception = true;
			$reponse->erreur    = "Erreur de paramètres";
			return $reponse;
		}
		$statement = Database::$instance->prepare("SELECT * FROM position WHERE id = :id ;");
		$statement->execute(array(":id" => $id));
		$reponse->existe = $statement->fetch()['id'] == $id;
		return $reponse;
	}

	static function selectionner($id){

		$reponse  = new stdClass();
		//Vérification du paramètre en entrée
		if($id == null || $id != intval($id)){
			$reponse->exception = true;
			$reponse->erreur    = "Erreur de paramètres";
			return $reponse;
		}
		//sélection du lieu dans la base
		$statement = Database::$instance->prepare("SELECT * FROM position WHERE id = :id ;");
		$statement->execute(array(":id" => $id));
		$reponse->position = $statement->fetch();
		//On retire les lignes doublons du tableau 
		for ($i=0; $i<count($reponse->position); $i++){
			unset($reponse->position[$i]);
		}
		return $reponse;
	}

	static function modifier(){
		
	}

	static function supprimer(){

	}

}

?>