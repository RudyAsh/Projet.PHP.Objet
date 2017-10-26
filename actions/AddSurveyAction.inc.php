<?php

require_once("model/Survey.inc.php");
require_once("model/Response.inc.php");
require_once("actions/Action.inc.php");

class AddSurveyAction extends Action {
	/**
	 * Traite les données envoyées par le formulaire d'ajout de sondage.
	 *
	 * Si l'utilisateur n'est pas connecté, un message lui demandant de se connecter est affiché.
	 *
	 * Sinon, la fonction ajoute le sondage à la base de données. Elle transforme
	 * les réponses et la question à l'aide de la fonction PHP 'htmlentities' pour éviter
	 * que du code exécutable ne soit inséré dans la base de données et affiché par la suite.
	 *
	 * Un des messages suivants doivent être affichés à l'utilisateur :
	 * - "La question est obligatoire.";
	 * - "Il faut saisir au moins 2 réponses.";
	 * - "Merci, nous avons ajouté votre sondage.".
	 *
	 * Le visiteur est finalement envoyé vers le formulaire d'ajout de sondage en cas d'erreur
	 * ou vers une vue affichant le message "Merci, nous avons ajouté votre sondage.".
	 *
	 * @see Action::run()
	 */
	public function run() {
		/* TODO START */
		if ($_POST['questionSurvey'] == ""){
			$this->setAddSurveyFormView("La question est obligatoire.", 'alert-error');
		}
		elseif ($_POST['responseSurvey1'] == "" or $_POST['responseSurvey2'] == ""){
			$this->setAddSurveyFormView("Il faut saisir au minimum 2 réponses.", 'alert-error');
		}
		else{
			$surv = new Survey($this->getSessionLogin(), $_POST['questionSurvey']);
			$surv->setResponses(array($_POST['responseSurvey1'], $_POST['responseSurvey2'], $_POST['responseSurvey3'], $_POST['responseSurvey4'], $_POST['responseSurvey5']));
			$this->database->saveSurvey($surv);
			$this->setView(getViewByName('Message'));
			$this->getView()->setMessage("Merci, nous avons ajouté votre sondage");
		}
		/* TODO END */
	}

	private function setAddSurveyFormView($message) {
		$this->setView(getViewByName("AddSurveyForm"));
		$this->getView()->setMessage($message, "alert-error");
	}

}

?>
