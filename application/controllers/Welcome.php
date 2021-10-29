<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation','session','database');
		$this->load->model('Query_model','q');
	}


	public function index(){
		$this->load->view('welcome_message');
	}


	public function allquestions(){
		$res=$this->q->select("tbl_question","result");	
		if($res){
			$data=array("status"=>1,"question"=>count($res));
			echo json_encode($data);
		}	
		else{
			$data=array("status"=>1,"question"=>0);
			echo json_encode($data);
		}
	}

	public function check_user(){
		$this->form_validation->set_rules('user_name','User Name','trim|required|min_length[2]',array("required"=>"Please enter your user name","min_length"=>"At least minimum two character is required"));	
		if($this->form_validation->run() == false){
			$msg="";
            if(form_error('user_name')){
                $msg=strip_tags(form_error('user_name'));
            }
			$data=array("status"=>0,"msg"=>$msg);
			echo json_encode($data);
		}
		else{
			$res=$this->q->select_where("tbl_users",array("user_name"=>$this->input->post("user_name")),"row");
			if($res){				
				$data=array("status"=>1,"data"=>$res,"msg"=>"");
				echo json_encode($data);
			}
			else{
				$saveUser=array(
					"user_name"=>$this->input->post("user_name")
				);
				$new=$this->q->insert("tbl_users",$saveUser);
				if($new > 0){					
					$res=$this->q->select_where("tbl_users",array("user_name"=>$this->input->post("user_name")),"row");
					$data=array(
						"status"=>1,
						"data"=>$res,
						"msg"=>""
					);
					echo json_encode($data);
				}
				else{					
					$data=array(
						"status"=>0,
						"msg"=>"Please enter your User Name"
					);
					echo json_encode($data);
				}
			}
		}
	}

	function setquestion($next){
		$newoffset=$next-1;
		$limit=1;
		$res=$this->q->select_limit_offset("tbl_question",$newoffset,$limit,"row");
		if($res){
			$newRes=array(
				"id"=>$res->id,
				"question"=>$res->question,
				"option1"=>$res->option1,
				"option2"=>$res->option2,
				"option3"=>$res->option3,
				"option4"=>$res->option4
			);
			return $newRes;
		}
		else{
			return false;
		}
	}

	public function getquestion(){	
		$next=$this->input->post("next");
		$res=$this->setquestion($next);
		if($res){				
			$data=array("status"=>1,"data"=>$res);
			echo json_encode($data);
		}
		else{	
			$msg="Question not found";		
			$data=array("status"=>0,"msg"=>$msg);
			echo json_encode($data);
		}
	}

	
	public function nextquestion(){
		$this->form_validation->set_rules('id','User Name','trim|required|min_length[1]',array("required"=>"Please enter your user name"));
		$this->form_validation->set_rules('question_id','Question','trim|required',array("required"=>"Question is required"));	
		$this->form_validation->set_rules('user_ans','User Ans','trim|required',array("required"=>"User Answer is required"));		
		$this->form_validation->set_rules('next','Next','trim|required',array("required"=>"Next is required"));		
		if($this->form_validation->run() == false){
			$msg="";
            if(form_error('id')){
                $msg=strip_tags(form_error('id'));
            }
            else if(form_error('question_id')){
                $msg=strip_tags(form_error('question_id'));
            }
            else if(form_error('user_ans')){
                $msg=strip_tags(form_error('user_ans'));
            }
            else if(form_error('next')){
                $msg=strip_tags(form_error('next'));
            }
			$data=array("status"=>0,"msg"=>$msg);
			echo json_encode($data);
		}
		else{
			$userAns=array(
				"user_id"=>$this->input->post("id"),
				"question_id"=>$this->input->post("question_id"),
				"user_ans"=>$this->input->post("user_ans"),
				"skip_ans"=>""
			);
			$res=$this->q->insert("tbl_answers",$userAns);
			if($res > 0){	
				$correct_ans=0;
				$wrong_ans=0;
				$checkans=$this->q->select_where("tbl_question",array("id"=>$this->input->post("question_id")),"row");
				if($checkans){
					if($this->input->post("user_ans")==$checkans->ans_option){
						$correct_ans=1;
					}
					else{
						$wrong_ans=1;
					}
				}
								
				$ru=$this->q->select_where("tbl_results",array("user_id"=>$this->input->post("id")),"row");
				if($ru){							
					$rUpdate=array(
						"correct_ans"=>$ru->correct_ans+$correct_ans,
						"wrong_ans"=>$ru->wrong_ans+$wrong_ans
					);					
					$this->q->update("tbl_results",$rUpdate,$ru->id);
				}
				else{								
					$rInsert=array(
						"user_id"=>$this->input->post("id"),
						"correct_ans"=>$correct_ans,
						"wrong_ans"=>$wrong_ans,
						"skip_ans"=>0
					);
					$this->q->insert("tbl_results",$rInsert);
				}

				$next=$this->input->post("next")+1;
				$nextres=$this->setquestion($next);
				if($nextres){				
					$data=array("status"=>1,"data"=>$nextres);
					echo json_encode($data);
				}
				else{	
					$msg="Question not found";		
					$data=array("status"=>0,"msg"=>$msg);
					echo json_encode($data);
				}
				
			}
			else{
				$data=array("status"=>0,"msg"=>"Next function is not working proper");
				echo json_encode($data);
			}
		}
	}
	
	public function skipquestion(){		
		$this->form_validation->set_rules('id','User Name','trim|required|min_length[1]',array("required"=>"Please enter your user name"));
		$this->form_validation->set_rules('question_id','Question','trim|required',array("required"=>"Question is required"));
		$this->form_validation->set_rules('next','Next','trim|required',array("required"=>"Next is required"));		
		if($this->form_validation->run() == false){
			$msg="";
            if(form_error('id')){
                $msg=strip_tags(form_error('id'));
            }
            else if(form_error('question_id')){
                $msg=strip_tags(form_error('question_id'));
            }
            else if(form_error('next')){
                $msg=strip_tags(form_error('next'));
            }
			$data=array("status"=>0,"msg"=>$msg);
			echo json_encode($data);
		}
		else{
			$userAns=array(
				"user_id"=>$this->input->post("id"),
				"question_id"=>$this->input->post("question_id"),
				"user_ans"=>"",
				"skip_ans"=>1
			);
			$res=$this->q->insert("tbl_answers",$userAns);
			if($res > 0){						
				$ru=$this->q->select_where("tbl_results",array("user_id"=>$this->input->post("id")),"row");
				if($ru){							
					$rUpdate=array(
						"skip_ans"=>$ru->skip_ans+1
					);					
					$this->q->update("tbl_results",$rUpdate,$ru->id);
				}
				else{								
					$rInsert=array(
						"user_id"=>$this->input->post("id"),
						"correct_ans"=>0,
						"wrong_ans"=>0,
						"skip_ans"=>1
					);
					$this->q->insert("tbl_results",$rInsert);
				}

				$next=$this->input->post("next")+1;
				$nextres=$this->setquestion($next);
				if($nextres){				
					$data=array("status"=>1,"data"=>$nextres);
					echo json_encode($data);
				}
				else{	
					$msg="Question not found";		
					$data=array("status"=>0,"msg"=>$msg);
					echo json_encode($data);
				}
			}
			else{
				$data=array("status"=>0,"msg"=>"Skip function is not working proper");
				echo json_encode($data);
			}
		}
	}

	function resultuser(){		
		$this->form_validation->set_rules('id','User Name','trim|required|min_length[1]',array("required"=>"Please enter your user name"));
		if($this->form_validation->run() == false){
			$msg="";
            if(form_error('id')){
                $msg=strip_tags(form_error('id'));
            }
			$data=array("status"=>0,"msg"=>$msg);
			echo json_encode($data);
		}
		else{
			$res=$this->q->select_where("tbl_results",array("user_id"=>$this->input->post("id")),"row");
			if($res){
				$newRes=array(
					"correctans"=>$res->correct_ans,
					"wrongans"=>$res->wrong_ans,
					"skipans"=>$res->skip_ans
				);
				$data=array("status"=>1,"data"=>$newRes);
				echo json_encode($data);
			}
			else{
				$newRes=array(
					"correctans"=>0,
					"wrongans"=>0,
					"skipans"=>0
				);
				$data=array("status"=>0,"data"=>$newRes);
				echo json_encode($data);
			}
		}
	}

}
