<?php namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Exceptions\PageNotFoundException;

use App\Models\SurveyModel;
use App\Models\QuestionModel;
use App\Models\OptionModel;
use App\Models\ParticipantModel;

	/*
	*  Notes for reader
	- All validations are handled in the models
	- Avoided using any helpers in the view (Simple Pure HTML5)
	- Please do Comment on the code so i would learn from you
	*/

	// TODO: Considering adding a method(function) that can handle response data, also another one to handle errors and status messages

class Survey extends BaseController
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

			// load sample session for testing purposes
			$userData = [
				'user' => [
					'user_id' => '1',
					'logged_in' => true,
					'group' => ['standard'],
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

		$this->data['surveys'] = $this->sModel->where('user_id', session('user.user_id'))->findAll();
		return view('sur_main', $this->data);
	}
//--------------------------------------------------------------------
/**
	* Load create survey form or process survey form
	*/
	public function create()
	{
		if ($this->request->getMethod() === 'post') {

			$sData = array_merge(['user_id' => session('user.user_id')], $this->request->getPost());
			if ($this->sModel->insert($sData)) {
				session()->setFlashdata('status', 'New survey added.');
				return redirect()->to('/');
			}
				session()->setFlashdata('status', "Unable to add new survey.");
				session()->setFlashdata('errors', $this->sModel->errors());
				return redirect()->back()->withInput();
		}

		return view('sur_create', $this->data);
	}
//--------------------------------------------------------------------
/**
	* Load edit survey form or process edit survey form
	*/
	public function revamp(int $sId = null)
	{
		if (is_null($sId)) {
			throw new PageNotFoundException("Does not exist!");
		}
		if ($this->request->getMethod() === 'post') {
			// Check integrity
			if (!$this->sModel->where('user_id', session('user.user_id'))->where('id', $this->request->getPost('id'))->first()) {
				throw new PageNotFoundException("Does not exist!");
			}
			// Save data db
			if ($this->sModel->save($this->request->getPost())) {
				// Set message and redirect to main page
				session()->setFlashdata('status', 'Survey updated.');
				return redirect()->to('/');
			}
			session()->setFlashdata('status', "Unable to update survey.");
			session()->setFlashdata('errors', $this->sModel->errors());
			return redirect()->back()->withInput();
		}

		// Check integrity
		if (!$this->sModel->where('user_id', session('user.user_id'))->where('id', $sId)->first()) {
			throw new PageNotFoundException("Does not exist!");
		}
		// Get survey data and load edit form
		$this->data['survey'] = $this->sModel->find($sId);
		return view('sur_revamp', $this->data);
	}
	//--------------------------------------------------------------------
	/**
		* Get survey if ID is set otherwise get all surveys
		*/
		public function fetch(int $sId = null)
		{
			if (!is_null($sId)) {
				if (!$this->sModel->where('user_id', session('user.user_id'))->where('id', $sId)->first()) {
					throw new PageNotFoundException("Does not exist!");
				}
				$this->data['survey'] 	 = $this->sModel->find($sId);
				$this->data['questions'] = $this->qModel->where('survey_id', $sId)->findAll();
				$this->data['options'] 	 = $this->oModel->where('survey_id', $sId)->findAll();

				return view('sur_singular', $this->data);
			}

			$this->data['surveys'] = $this->sModel->where('user_id', session('user.user_id'))->findAll();
			return view('sur_plural', $this->data);
		}
//--------------------------------------------------------------------
/**
	* Load Survey, questions count, and add question and options form.
	*/
	public function affix(int $sId = null)
	{
		if (is_null($sId)) {
			throw new PageNotFoundException("Cannot Process your Request");
		}
		if (!$this->data['survey'] = $this->sModel->where('user_id', session('user.user_id'))->where('id', $sId)->first()) {
			throw new PageNotFoundException("Cannot Process your Request");
		}

		$this->data['questions'] = $this->qModel->where('survey_id', $sId)->findAll();
		$this->data['count'] = count($this->data['questions']);

		return view('sur_affix', $this->data);
	}
//--------------------------------------------------------------------
/**
	* Get ajax calls and process adding questions and options to the DB.
	* Code: 100 = OK, 110 = fail
	*/
public function affixq()
{
	if ($this->request->isAjax() && $this->request->getMethod() === 'post' && $this->request->getPost('sid', FILTER_VALIDATE_INT)) {

			//$data['formD'] = $this->request->getPost();
			$sId = $this->request->getPost('sid', FILTER_VALIDATE_INT);
			// Check integrity
			if (!$this->sModel->where('user_id', session('user.user_id'))->where('id', $sId)->first()) {
				$this->data['code'] = 110;
				$this->data['status'] = 'Cannot process your request';
				$this->data['errors'] = $this->sModel->errors();
				return json_encode($this->data);
			}
			// Prepare data
			$questionData = [
				'user_id' 	=> session('user.user_id'),
				'survey_id' => $sId,
				'content' 	=> $this->request->getPost('content'),
				'type' 			=> $this->request->getPost('questionType'),
			];
			// Save question data
			if (!$this->qModel->save($questionData)) {
				$this->data['code'] = 110;
				$this->data['status'] = false;
				$this->data['errors'] = $this->qModel->errors();
				return json_encode($this->data);
			}
			if ($this->request->getPost('questionType') == 'textarea') {
				$this->data['code'] = 100;
				$this->data['status'] = 'Question added.';
				return json_encode($this->data);
			}
			// Prepare Options data
			$questionId = $this->qModel->insertID();
			$options = $this->request->getPost('option');
			// Options are array therefor we use loop to handle insert (Needs improvment though)
			foreach ($options as $option) {
					$optionData = [
						'user_id' => session('user.user_id'),
						'survey_id' => $sId,
						'question_id' => $questionId,
						'option' => $option
					];
					// Needs a way to handle errors
					$this->oModel->save($optionData);
					unset($optionData);
			}
			$this->data['code'] = 100;
			$this->data['status'] = 'Question with Options added.';
			return json_encode($this->data);
	}
	// Respond with fail status
	$this->data['code'] 	= 110;
	$this->data['status'] = 'Its not ajax request.';
	return json_encode($this->data);
}
//--------------------------------------------------------------------
/**
	*
	*/
public function detach()
{
	if ($this->request->isAjax() && $this->request->getMethod() === 'post' && $this->request->getVar('id', FILTER_VALIDATE_INT)) {

			if ($this->qModel->where('id', $this->request->getVar('id'))->where('user_id', session('user.user_id'))->first()) {

				$this->qModel->delete($this->request->getVar('id'));

				if($this->qModel->affectedRows() !== 0){
					$this->data['code'] = 100;
					$this->data['status'] = "Record deleted.";

					return $this->response->setJSON($this->data);
					//return json_encode($this->data);
				}
			}
	}
	// Respond with fail status
	$this->data['code'] 	= 110;
	$this->data['status'] = 'Cannot process your request.';
	return json_encode($this->data);
}
//--------------------------------------------------------------------
/**
	*
	*/
public function removes()
{
	if ($this->request->isAjax() && $this->request->getMethod() === 'post' && $this->request->getVar('id', FILTER_VALIDATE_INT)) {

		if ($this->sModel->where('id', $this->request->getVar('id'))->where('user_id', session('user.user_id'))->first()) {

				$this->sModel->delete($this->request->getVar('id'));

				if($this->sModel->affectedRows() !== 0){
					$this->data['code'] = 100;
					$this->data['status'] = "Survey and its componenets deleted.";
					return json_encode($this->data);
				}
		}
	}
	// Respond with fail status
	$this->data['code'] 	= 110;
	$this->data['status'] = 'Cannot process your request.';
	return json_encode($this->data);
}
//--------------------------------------------------------------------
/**
	*
	*/
public function removesurvey(int $sid = null)
{
	if (is_null($sid)) {
		die();
	}

	if ($this->sModel->where('id', $sid)->where('user_id', session('user.user_id'))->first()) {

			$this->sModel->delete($sid);

			if($this->sModel->affectedRows() !== 0){
				return redirect()->to('/');
			}
	}
	echo 'cannot process your request';
	die();
}
//--------------------------------------------------------------------
/**
	*
	*/
public function publish(int $id = null)
{
	if (!is_null($id)) {
			// Check integrity
			if ($this->sModel->where('id', $id)->where('active', 0)->where('user_id', session('user.user_id'))->first()) {
				$this->data['queCount'] = $this->qModel->where('survey_id', $id)->countAll();
				$this->data['survey'] 	= $this->sModel->find($id);
				return view('sur_publish', $this->data);
			}


			echo 'Its active.';
			return null;
	}

	if (!$this->request->getMethod() === 'post') {
	 return null;
	}

	if (!$this->request->getPost('id', FILTER_VALIDATE_INT)) {
	return null;
	}

	$saveData = [
		'id' => $this->request->getPost('id'),
		'active' => 1,
		'start_at' => $this->request->getPost('start_at'),
		'end_at' => $this->request->getPost('end_at'),
		'link' => $this->initiateToken(),
	];

	if(!$this->sModel->where('user_id', session('user.user_id'))->save($saveData))
	{
		return null;
	}
$aurvey = $this->sModel->where('id', $saveData['id'])->where('user_id', session('user.user_id'))->first();
	$part = [
		'token' => $saveData['link'],
		'survey_id' => $saveData['id'],
		'title'	=> $survey['title'],
		'takers' => 0,
		'finished' => 0,
	];

	if (!$this->pModel->save($part)) {
		// Need to do reverse for previuse query
		var_dump($this->pModel->errors());

		return null;
			throw new PageNotFoundException("Cannot Process your Request");
	}

	return redirect()->to('/survey/fetch/'.$this->request->getPost('id'));

}
//--------------------------------------------------------------------
/**
	*
	*/
public function unpublish(int $id = null)
{



}

private function initiateToken()
{
	$token = sha1(uniqid('', true));
	return $token;
}

//--------------------------------------------------------------------
}
