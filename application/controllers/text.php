<?php

class Text_Controller extends Base_Controller{
	
	public function action_index(){
		return View::make('home.index');
	}

	public function action_loadTermsSearch(){
		$textRepository = new EuropeanaTermRepository();
		$terms = $textRepository->get_TermList();
		return Response::json($terms);
	}
	
}