<?php

namespace Model;

class JsonFinder implements FinderInterface
{

	private $fichier;
	
	public function __construct($fichier) {
		$this->fichier = $fichier;
	}

	/**
     * Returns all elements.
     *
     * @return array
     */
    public function findAll()
    {
		$tabJson = file_get_contents($this->fichier);
		$aCommentaire = json_decode($tabJson, true);
		
		return $aCommentaire;
	}

    /**
     * Retrieve an element by its id.
     *
     * @param  mixed      $id
     * @return null|mixed
     */
    public function findOneById($id)
    {
		$tabJson = file_get_contents($this->fichier);
		$aCommentaire = json_decode($tabJson, true);
		if (isset($aCommentaire[$id]["commentaire"])) {
			$retour = $aCommentaire[$id]["commentaire"];
		} else {
			$retour = "Ce statut n'existe pas !";
		}
		return $retour;
	}
	
	public function addStatus($author, $commentaire) {
		$tab = json_decode(file_get_contents($this->fichier), true);
		$tab[] = array("auteur" => $author ,"commentaire" => $commentaire);
		$json = json_encode($tab);
		file_put_contents($this->fichier, $json);	
	}
	
	public function removeStatus($id) {
		$tab = json_decode(file_get_contents($this->fichier), true);
		if (isset($tab[$id])) {
			unset($tab[$id]);
			$json = json_encode($tab);
			file_put_contents($this->fichier, $json);
		} else {
			throw new HttpException(404, "Object doesn't exist");
		}
	}
}
