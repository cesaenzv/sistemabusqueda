<?php

class Text_Controller extends Base_Controller{
	
	public function action_index(){
		return View::make('home.index');
	}

	public function action_loadTermsSearch(){
		$europeanaTR = new EuropeanaTermRepository();
		$terms = $europeanaTR->get_TermList();
		return Response::json($terms);
	}
	
}