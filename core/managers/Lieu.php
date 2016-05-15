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
	static function ajouter($libelle, $ville){

		$reponse  = new stdClass();
		//Vérification du paramètre en entrée
		if(strlen($libelle) == 0 || strlen($ville) == 0){
			$reponse->exception = true;
			$reponse->erreur    = "Erreur de paramètres";
			return $reponse;
		}
		//Ajout du lieu dans la BDD
		$statement = Database::$instance->prepare("INSERT INTO lieu (carte, libelle, ville) VALUES( null, :libelle, :ville );");
		$reponse->ajoutOK = $statement->execute(array(	":libelle" => $libelle,
														":ville" => ucfirst($ville)));
		return $reponse;

	}

	/**
	* Modifie le libelle du lieu dont l'id est passé en paramètre
	* @param $id l'id du lieu à modifier
	* @param $libelle le nouveau libelle à enregistrer 
	*/
	static function modifier($id, $libelle){

		$reponse  = new stdClass();
		//Vérification du paramètre en entrée
		if(strlen($libelle) == 0 || strlen($libelle) >= 30 || $id == null || $id != intval($id)){
			$reponse->exception = true;
			$reponse->erreur    = "Erreur de paramètres ou id invalide";
			return $reponse;
		}

		//Modification du nom
		$statement = Database::$instance->prepare("UPDATE lieu SET libelle = :libelle WHERE id = :id ;");
		$reponse->modifOK = $statement->execute(array(	":libelle" => $libelle,
														":id" => $id));
		return $reponse;

	}



	/**
	* Supprime le lieu dont l'id est passé en paramètres, ainsi que l'intégralité de ses cartes enregistrées 
	* @param id l'identifiant du lieu
	*/
	static function supprimer($id){

		$reponse  = new stdClass();
		//Vérification du paramètre en entrée
		if($id !== intval($id)){
			$reponse->exception = true;
			$reponse->erreur    = "Erreur de paramètres";
			return $reponse;
		}

		//On passe la carte du lieu à nulle afin de toutes les supprimer
		$statement        = DataBase::$instance->prepare("UPDATE lieu SET carte = NULL WHERE id = :id ;");
		$reponse->modifPP = $statement->execute(array(	":id" 	=> $id));

		//suppression de toutes les cartes dans la BdD
		$statement = DataBase::$instance->prepare("DELETE FROM image WHERE id_lieu = :id_lieu ;");
		$reponse->avatarsSuppr = $statement->execute(array(':id_lieu' => $id));
		unset($statement);
		if (!$reponse->avatarsSuppr){
			$reponse->exception = true;
			return $reponse;
		}

		//Suppression des avatars sur le serveur
		exec("rm -rf ".CARTE.$id);

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
		for ($i=0; $i<count($lieu); $i++){
			unset($lieu[$i]);
		}
		$reponse->lieu = $lieu;
		return $reponse;
	}


	/**
	 * Inscrit Jean-Kévin à un lieu enregistré
	 * @param $id id du lieu auquel JK souhaite s'inscrire
	 * @param $jean_kevin l'identifiant du JK correspondant 
	 * @return vrai en cas de succès faux sinon
	 */
	static function ajouterLieuJK($id, $jean_kevin){

		$reponse  = new stdClass();
		//Vérification du paramètre en entrée
		if(strlen($jean_kevin) == 0 || $id == null || $id != intval($id)){
			$reponse->exception = true;
			$reponse->erreur    = "Erreur de paramètres";
			return $reponse;
		}
		//Ajout de la relation JK - Lieu
		$statement = Database::$instance->prepare("INSERT INTO `r_jk_lieu`(`identifiant_jk`, `id_lieu`)" 
			." VALUES ( :jean_kevin , :id ) ;");
		$reponse->ajoutLienOK = $statement->execute(array(":id" 	  => $id,
														":jean_kevin" => $jean_kevin));
		return $reponse;
	}


	/**
	* Sélectionne tous les lieux de Jean Kévin
	* @param $jean_kevin l'identifiant de JK
	*/
	static function selectionnerLieuxJK($jean_kevin){

		$reponse  = new stdClass();
		//Vérification du paramètre en entrée
		if(strlen($jean_kevin) == 0){
			$reponse->exception = true;
			$reponse->erreur    = "Erreur de paramètres";
			return $reponse;
		}

		$statement = Database::$instance->prepare("SELECT l.id, l.libelle, l.ville FROM lieu l, r_jk_lieu r"
			." WHERE r.identifiant_jk = :identifiant"
			." AND l.id = r.id_lieu;");
		$statement->execute(array(":identifiant" => $jean_kevin));
		$lieux = $statement->fetchAll();
		//On supprime les lignes doublons
		if($lieux != false){
			foreach ($lieux as $num => &$lieu) {
				for ($i=0; $i < count($lieu); $i++) { 
					unset($lieu[$i]);
				}
			}
		}
		$reponse->lieux = $lieux;
		return $reponse;

	}

	static function supprimerLieuJK($id, $jean_kevin){

		$reponse  = new stdClass();
		//Vérification du paramètre en entrée
		if(strlen($jean_kevin) == 0 || $id == null || $id != intval($id)){
			$reponse->exception = true;
			$reponse->erreur    = "Erreur de paramètres";
			return $reponse;
		}

		//Suprression de la relation JK - Lieu
		$statement = Database::$instance->prepare("DELETE FROM `r_jk_lieu` " 
			." WHERE identifiant_jk = :jean_kevin AND id_lieu = :id ;");
		$reponse->suppressionOK = $statement->execute(array(":id"		  => $id,
															":jean_kevin" => $jean_kevin));
		return $reponse;
	}

	
	/**
	 * Effectue une recherche parmi les lieux enregistrés dans la base de données
	 * @param mot_cle le mot clé à rechercher
	 */
	static function rechercher($mot){

		$reponse  = new stdClass();
		//Vérification du paramètre en entrée
		if(strlen($mot) == 0){
			$reponse->exception = true;
			$reponse->erreur    = "Erreur de paramètres";
			$reponse->mot = $mot;
			return $reponse;
		}

		//Sélection des JK correspondants
		$statement = Database::$instance->prepare("SELECT DISTINCT id, libelle, ville FROM lieu"
				." WHERE libelle LIKE :mot_deb OR libelle LIKE :mot_mil OR libelle LIKE :mot_fin "
				." ORDER BY libelle, id ");
		$statement->execute(array(	":mot_deb" => "$mot%",
									":mot_mil" => "%$mot%",
									":mot_fin" => "%$mot"));
		$reponse->resultats = $statement->fetchAll();
		//On supprime les doublons du tableau
		foreach($reponse->resultats as &$lieu){
			for($i=0; $i<count($lieu) ;$i++){
				unset($lieu[$i]);
			}
		}

		return $reponse;
	}


}


?>