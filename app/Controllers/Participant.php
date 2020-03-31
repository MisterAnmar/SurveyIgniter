<?php namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Exceptions\PageNotFoundException;

use App\Models\SurveyModel;
use App\Models\QuestionModel;
use App\Models\OptionModel;
use App\Models\ParticipantModel;


class Participant extends BaseController
{

public $data = [];
//
private $sModel;
private $qModel;
private $oModel;
private $pModel;

	public function __construct()
	{
		// Initiate Models Objects
		$this->sModel = new SurveyModel();
		$this->qModel = new QuestionModel();
		$this->oModel = new OptionModel();
		$this->pModel = new ParticipantModel();

	}
//--------------------------------------------------------------------
/**
	 * Load main view page (System Starting point)
	 */
  public function index()
	{
		echo $this->request->getIPAddress();
	}
  //--------------------------------------------------------------------
  /**
  	 * Load main view page (System Starting point)
  	 */
    public function serve($token = null)
  	{

			// Validate Token || Validate survey exist and active
      if (is_null($token) || !$this->validateToken($token) || !$this->sModel->where('link', $token)->where('active', 1)->first()) {
        throw new PageNotFoundException("Cannot Process your Request");
      }
			// Check Cookie
			if (!isset($_COOKIE['sur_'.$token])) {
				// set cookie
				setcookie('sur_'.$token, 'No', time() + WEEK, "/");
			}else {
				// Check cookie status
				if ($_COOKIE['sur_'.$token] == 'Yes') {
					// if Yes means he/she have taken this survey..
					throw new PageNotFoundException("Cannot Request");
				}
			}



			//Update counter
			$this->data['survey'] 	 = $this->sModel->where('link', $token)->first();
			$this->data['part'] 	 = $this->pModel->where('survey_id', $this->data['survey']['id'])->where('token', $token)->first();
			$countData = [
				'id'				=> $this->data['part']['id'],
				'takers' 		=> $this->data['part']['takers'] + 1,
			];


			$this->pModel->save($countData);
			// Load survey related data
      //$this->data['survey'] 	 = $this->sModel->where('link', $token)->first();
      $this->data['questions'] = $this->qModel->where('survey_id', $this->data['survey']['id'])->findAll();
      $this->data['options'] 	 = $this->oModel->where('survey_id', $this->data['survey']['id'])->findAll();

      return view('par_survey', $this->data);
  	}

		public function process()
		{
			// Validate Token
			$this->validateToken($token = null);
			//var_dump($this->request->getCookie($token,FILTER_SANITIZE_STRING));
			return null;
			
			//Validate Input
			if (!$this->request->getMethod() === 'post') {
				return null;
			}
			if (!$this->request->getPost('id', FILTER_VALIDATE_INT)) {
				return null;
			}

			// Update Counter

			// Load confirmation
			return view('par_complete', $this->data);
		}
		//--------------------------------------------------------------------
	  /**
	  	 * Validate token (Link)
	  	 */
    private function validateToken($token = null)
  	{
  			if (preg_match('/^[0-9A-F]{40}$/i', $token)) {
  				return true;
  			}

        return false;
  	}

//--------------------------------------------------------------------

}
