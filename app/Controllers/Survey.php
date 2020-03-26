<?php namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Exceptions\PageNotFoundException;

use App\Models\SurveyModel;
use App\Models\QuestionModel;
use App\Models\OptionModel;

	/*
	*  Notes for reader
	- All validations are handled in the models
	- Avoided using any helpers in the view (Simple Pure HTML5)
	- Please do Comment on the code so i would learn from you
	*/

	// TODO: Considering adding a method(function) that can handle response data also another one to handle errors and status messages

class Survey extends BaseController
{

	public $data = [];

	public function __construct()
	{
			// load sample session for testing purposes
			$userData = [
				'user' => [
					'user_id' => 10,
					'logged_in' => true,
					'group' => ['standard', 'example2', 'example3'],
				],
				'setting' =>[
					'time_zone' => 'Something'
				]
			];
			session()->set($userData);
	}
//--------------------------------------------------------------------
/**
	 * Load main view page (System Starting point)
	 */
	public function index()
	{
		$surModel = new SurveyModel();
		$this->data['surs'] = $surModel->where('user_id', session('user.user_id'))->findAll();

		return view('sur_main', $this->data);
	}
//--------------------------------------------------------------------
/**
	*
	*/
	public function create()
	{
		if ($this->request->getMethod() === 'post') {
			$surModel = new SurveyModel();
			$saveData = array_merge(['user_id' => session('user.user_id')], $this->request->getPost());
			if ($surModel->save($saveData)) {
				session()->set('status', 'New Survey Added.');
				return redirect()->to('/survey/fetch/'.$surModel->insertID());
			}
			session()->set('status', 'Fail Adding.');
			session()->set('errors', $surModel->errors());
			return redirect()->back()->withInput();
		}
		return view('sur_create', $this->data);
	}
	//--------------------------------------------------------------------
	/**
		*
		*/
	public function revamp($surID = null)
	{

		if (is_null($surID)) {
			throw new PageNotFoundException("Does not exist!");
		}

			$surModel = new SurveyModel();

		if ($this->request->getMethod() === 'post') {
			// Check integrity
				if (!$surModel->where('user_id', session('user.user_id'))->where('id', $this->request->getPost('id'))->first()) {
					throw new PageNotFoundException("Does not exist!");
				}
				if ($surModel->save($this->request->getPost())) {
					session()->set('status', 'Survey Updated.');
					return redirect()->to('/survey/fetch/'.$surID);
				}
				session()->set('status', 'Failed updating.');
				session()->set('errors', $surModel->errors());
				return redirect()->back()->withInput();
			}

			// Check integrity
		if (!$surModel->where('user_id', session('user.user_id'))->where('id', $surID)->first()) {
			throw new PageNotFoundException("Does not exist!");
		}

			$this->data['sur'] = $surModel->find($surID);
		return view('sur_revamp', $this->data);
	}
//--------------------------------------------------------------------
/**
	* Fetch single or all of surveys
	*/
	public function fetch($surID = null)
	{
		$surModel = new SurveyModel();
		$queModel = new QuestionModel();
		$optModel = new OptionModel();

		if (!is_null($surID)) {
			if (!$surModel->where('user_id', session('user.user_id'))->where('id', $surID)->first()) {
				throw new PageNotFoundException("Does not exist!");
			}
			$this->data['sur'] = $surModel->find($surID);
			$this->data['ques'] = $queModel->where('survey_id', $surID)->findAll();
			$this->data['opts'] = $optModel->where('survey_id', $surID)->findAll();

			return view('sur_singular', $this->data);
		}

		$this->data['surs'] = $surModel->where('user_id', session('user.user_id'))->findAll();
		return view('sur_plural', $this->data);
	}
//--------------------------------------------------------------------


public function deb()
{
	if ($this->request->isAjax()) {
		$json = $this->request->getJSON();

		$dataArray = json_decode(json_encode($json), true);




		$this->data['data'] = $dataArray;
		$this->data['message'] = "Ajax request";
		return json_encode($this->data);
	}

	$this->data['message'] = "Not an Ajax request";
	return json_encode($this->data);
}




//--------------------------------------------------------------------
/**
	*
	*/
	public function affix($surID = null)
	{
		if (is_null($surID)) {
			throw new PageNotFoundException("Cannot Processe your Request");
		}
		$surModel = new SurveyModel();
		$queModel = new QuestionModel();
		$optModel = new OptionModel();

		if (!$this->data['sur'] = $surModel->where('user_id', session('user.user_id'))->where('id', $surID)->first()) {
			throw new PageNotFoundException("Cannot Processe your Request");
		}

		$this->data['ques'] = $queModel->where('survey_id', $surID)->findAll();
		// $this->data['opts'] = $optModel->where('survey_id', $surID)->findAll();
		$this->data['count'] = count($this->data['ques']);

		//return view('sur_affixjs', $this->data);
		return view('sur_affix', $this->data);
	}
//--------------------------------------------------------------------
/**
	*
	*/
	public function affixq()
	{
	if ($this->request->isAjax()) {
			$this->data['formD'] = $this->request->getPost();
			$surID = $this->request->getPost('surID');
			if (! $this->validate([
			        'surID' 				=> "required|numeric|is_not_unique[survey.id,id,{$surID}]",
							'question'  		=> 'required|alpha_numeric_punct',
							'questionType'  => 'required|in_list[radio,checkbox,texarea]',
			    ])){
						$this->data['status'] = false;
						$this->data['errors'] = $this->validator->getErrors();
						$this->data['message'] = "Problem with validation.";
						return json_encode($this->data);
					}
			// First level validation Done
			// Load models
			$surModel = new SurveyModel();
			$queModel = new QuestionModel();
			$optModel = new OptionModel();
			// Check integrity
			if (!$this->data['sur'] = $surModel->where('user_id', session('user.user_id'))->where('id', $surID)->first()) {
				$this->data['status'] = false;
				$this->data['errors'] = $surModel->errors();
				$this->data['message'] = "Problem with integrity";
				return json_encode($this->data);
			}
			// Prepare data
			$questionData = [
				'user_id' => session('user.user_id'),
				'survey_id' => $surID,
				'question' => $this->request->getPost('question'),
				'type' => $this->request->getPost('questionType'),
			];
			if (!$queModel->save($questionData)) {
				$this->data['status'] = false;
				$this->data['errors'] = $queModel->errors();
				$this->data['message'] = "Problem with adding question.";
				return json_encode($this->data);
			}
			$queID = $queModel->insertID();
			$options = $this->request->getPost('option');
			foreach ($options as $option) {
					$optionsData = [
						'user_id' => session('user.user_id'),
						'survey_id' => $surID,
						'question_id' => $queID,
						'option' => $option
					];
					$optModel->save($optionsData);
					unset($optionsData);
				}

			unset($this->data);

			sleep(3);
			$this->data['status'] = true;
			$this->data['message'] = 'Question with Options added successfully.';
			return json_encode($this->data);
		}
		$this->data['status'] = false;
		$this->data['message'] = "Its not ajax request.";
		return json_encode($this->data);
	}
//--------------------------------------------------------------------

/********************************************************
*
*			To Be tested and added
*
********************************************************/
// TODO: test and edit

//--------------------------------------------------------------------
/**
	*
	*/
	public function validateToken($token = null)
	{
			if (is_null($token) || !preg_match('/^[0-9A-F]{40}$/i', $token)) {
				echo 'Not valid';
			}else {
				echo 'valid';
			}
	}
//--------------------------------------------------------------------
/**
	*
	*/
	public function initiateToken()
	{
		$token = sha1(uniqid('', true));
		echo $token;
	}

}
