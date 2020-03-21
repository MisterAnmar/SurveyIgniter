<?php namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Exceptions\PageNotFoundException;

use App\Models\SurveyModel;
use App\Models\QuestionModel;

/*
*  Notes for reader
- All validations are handled in the models
- Avoided using any helpers in the view (Simple Pure HTML5) (Sometimes just confuses me :-) ) 
- Please do Comment on the code so i would learn from you
*/

// TODO: Considering adding a method(function) that can handle response data also another one to handle errors and status messages

class Survey extends BaseController
{
// Works as a handler for any data that will be sent to view
public $data = [];

	
public function __construct()
{
	// load sample session for testing purposes
	$userData = [
		'user' => [
			'user_id' => 10,
			'logged_in' => true,
			'group' => ['standard', 'example2', 'example3']
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
		// Merge post data with user session
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

	if (!is_null($surID)) {
		if (!$surModel->where('user_id', session('user.user_id'))->where('id', $surID)->first()) {
			throw new PageNotFoundException("Does not exist!");
		}
		$this->data['sur'] = $surModel->find($surID);
		$this->data['ques'] = $queModel->where('survey_id', $surID)->findAll();

		return view('sur_singular', $this->data);
	}

	$this->data['surs'] = $surModel->where('user_id', session('user.user_id'))->findAll();
	return view('sur_plural', $this->data);
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

	$this->data['sur'] = $surModel->find($surID);
	$this->data['ques'] = $queModel->where('survey_id', $surID)->findAll();

	return view('sur_affix', $this->data);
}
/********************************************************
*
*		To Be tested and added
*	Anything Bellow is either not tested or not 
*	completed or its just a consideration
*
********************************************************/

//--------------------------------------------------------------------
/**
*
*/
public function affixq()
{
	if ($this->request->isAjax()) {
			$queModel = new QuestionModel();
			// TODO: Check itegrity of user and survey
			// TODO: Design a way to check validity of each question and answer options
			var_dump($this->request->getPost());
			return;
	}
	echo 'No Ajax';
	return;

	//return json_encode($this->data);
}

//--------------------------------------------------------------------
/**
 * Load main view page (System Starting point)
 */
public function commit()
{

if ($this->request->isAjax()) {
	// $json = $this->request->getJSON();
	// var_dump($json);
	// $myArray = json_decode(json_encode($json), true);
	// var_dump($myArray);
	echo "OK";
}

}

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
