<?php
class Controller_Emailtemplate extends MyController 
{
	public function before()
	{
		parent::before();
		$this->logged_in_as(array('admin'));		
	}

	public function action_index()
	{
		$this->template->links['settings']['current'] = true;
		$data['emailtemplates'] = Model_Emailtemplate::find('all');
		$this->template->title = "Emailtemplates";
		$this->template->content = View::forge('emailtemplate/index', $data);

	}

	public function action_edit($id = null)
	{
		if(is_null($id))
			throw new HttpNotFoundException;

		$this->template->links['settings']['current'] = true;

		$emailtemplate = Model_Emailtemplate::find($id);

		if(!$emailtemplate)
			throw new HttpNotFoundException;

		$tags_arr = Controller_Emailnew::tags();
		$data['tags'] = $tags_arr;

		$val = Model_Emailtemplate::validate('edit');

		if ($val->run())
		{
			$emailtemplate->subject = Input::post('subject');
			$emailtemplate->tag = Input::post('tag');
			$emailtemplate->body = Input::post('body');

			if ($emailtemplate->save())
			{
				Session::set_flash('success', 'Updated emailtemplate #' . $id);

				Response::redirect('emailtemplate');
			}

			else
			{
				Session::set_flash('error', 'Could not update emailtemplate #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$emailtemplate->subject = $val->validated('subject');
				$emailtemplate->tag = $val->validated('tag');
				$emailtemplate->body = $val->validated('body');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('emailtemplate', $emailtemplate, false);
		}

		$this->template->title = "Emailtemplates";
		$this->template->content = View::forge('emailtemplate/edit',$data);

	}
}
