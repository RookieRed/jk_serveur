<?php


Database::instancier();

/***************************************************
**                                                **
**    88           88                             **
**    88           ""                             **
**    88                                          **
**    88           88   ,adPPYba,  88       88    **
**    88           88  a8P_____88  88       88    **
**    88           88  8PP"""""""  88       88    **
**    88           88  "8b,   ,aa  "8a,   ,a88    **
**    88888888888  88   `"Ybbd8"'   `"YbbdP'Y8    **
**                                                **
****************************************************/


class Lieu {


	/**
	* Vérifie si le lieu existe dans la base de données
	* @param id l'identifiant du lieu
	*/
	static function existe($id){

		$reponse  = new stdClass();
		//Vérification du paramètre en entrée
		if($id == null || $id != intval($id)){
			$reponse->exception = true;
			$reponse->erreur    = "Erreur de paramètres";
			return $reponse;
		}

		$statement = Database::$instance->prepare("SELECT * FROM lieu WHERE id = :id ;");
		$statement->execute(array(":id" => $id));
		$reponse->existe = $statement->fetch()['id'] == $id;
		return $reponse;
	}



	/**
	* Ajoute un lieu dans la base de données
	* @param libelle le nom du lieu
	*/
	static function ajouter($libelle){

		$reponse  = new stdClass();
		//Vérification du paramètre en entrée
		if(strlen($libelle) != 0){
			$reponse->exception = true;
			$reponse->erreur    = "Erreur de paramètres";
			return $reponse;
		}
		//Ajout du lieu dans la BDD
		$statement = Database::$instance->prepare("INSERT INTO lieu (libelle) VALUES :libelle ;");
		$statement->execute(array(":libelle" => $libelle));


	}

	/**
	* 
	*/
	static function modifier(){

		$reponse  = new stdClass();
		//Vérification du paramètre en entrée
		if(strlen($libelle) != 0){
			$reponse->exception = true;
			$reponse->erreur    = "Erreur de paramètres";
			return $reponse;
		}

	}



	/**
	* Supprime le lieu dont l'id est passé en paramètres
	* @param id l'identifiant du lieu
	*/
	static function supprimer($id){

		$reponse  = new stdClass();
		//Vérification du paramètre en entrée
		if($id == null || $id != intval($id)){
			$reponse->exception = true;
			$reponse->erreur    = "Erreur de paramètres";
			return $reponse;
		}
		//Suppression du lieu
		$statement = Database::$instance->prepare("DELETE FROM lieu WHERE id = :id ;");
		$reponse->supprOK = $statement->execute(array(":id" => $id));
		return $reponse;
	}



	/**
	* Selectionne le lieu dont l'id est passé en paramètres
	* @param $id l'identifiant du lieu
	*/
	static function selectionner($id){

		$reponse  = new stdClass();
		//Vérification du paramètre en entrée
		if($id == null || $id != intval($id)){
			$reponse->exception = true;
			$reponse->erreur    = "Erreur de paramètres";
			return $reponse;
		}

		$statement = Database::$instance->prepare("SELECT * FROM lieu WHERE id = :id ;");
		$statement->execute(array(":id" => $id));
		$lieu = $statement->fetch();
		//On retire les lignes doublons du tableau 
		foreach ($i=0; $i<count($lieu); $i++){
			unset($lieu[$i]);
		}
		$reponse->lieu = $lieu;
		return $reponse;
	}



	/**
	* 
	*/
	static function selectionnerMesLieux($jean_kevin){

		$reponse  = new stdClass();
		//Vérification du paramètre en entrée
		if(strlen($jean_kevin) != 0){
			$reponse->exception = true;
			$reponse->erreur    = "Erreur de paramètres";
			return $reponse;
		}

		$statement = Database::$instance->prepare("SELECT lieu.id, lieu.libelle, lieu.schemas FROM lieu, r_jk_lieu"
			." WHERE r_jk_lieu.identifiant = :identifiant ;");
		$statement->execute(array(":identifiant" => $jean_kevin));
		$lieux = $statement->fatchAll();

		//On supprime les lignes doublons
		

	}

	/**
	* 
	*/
	static function rechercher($mot){

	}


}


?>