<?php

class Controller_File extends MyController
{
	public function action_index()
	{
		$this->logged_in_as(array('admin','seller'));
		(is_null($this->param('item')) || !in_array($this->param('item'), array('yachtshare','buyer'))) and Response::redirect('yachtshare');
		$id = $this->param('id');

		if($this->param('item') == 'yachtshare')
		{
			$data['item'] = Model_Yachtshare::find($id);
			$data['type'] = 'yachtshare';
			$this->template->title = "Yachtshare: ".$data['item']->name;
			$this->template->links['shares']['current'] = true;
		}else{
			$data['item'] = Model_Buyer::find($id);
			$data['type'] = 'buyer';
			$this->template->title = "Buyer: ".$data['item']->name;
			$this->template->links['buyers']['current'] = true;
		}

		$data['files'] = Model_Image::find('all', array('where' => array('belongs_to' => $data['type'], 'belongs_to_id' => $id)));

		if($this->user->type == 'admin')
		{
			$this->template->content = View::forge('file/index',$data,false);				
		}else{
			return new Response(View::forge('file/seller/index', $data, false));					
		}

	}

	public function action_upload()
	{
		$this->logged_in_as(array('admin','seller'));
		if(Input::method() == 'POST')
		{
			// Custom configuration for this upload
			$config = array(
				'path' => DOCROOT.'uploads',
				'randomize' => true,
			);

			// process the uploaded files in $_FILES
			Upload::process($config);

			// if there are any valid files then save them
			(Upload::is_valid()) and Upload::save();

			foreach(Upload::get_files() as $file)
			{
				$type_arr = explode("/", $file['mimetype']);
				$public = (Input::post('public_image')) ? 1 : 0;
				//Save it to the database
				$file_db = Model_Image::forge(array(
					'belongs_to_id' => Input::post('belongs_to_id'),
					'belongs_to' => Input::post('belongs_to'),
					'public_image' => $public,
					'url' => $file['saved_as'],
					'type' => $type_arr[0],
				));

				if($file_db and $file_db->save())
				{
					Session::set_flash('success', 'Your '.$type_arr[0].' has been successfully uploaded.');
				}else{
					Session::set_flash('error', 'Your '.$type_arr[0].' was not uploaded due to an error.');					
				}

				Response::redirect('file/'.Input::post('belongs_to').'/'.Input::post('belongs_to_id'));
			}
		}
	}

	public function action_delete()
	{
		$this->logged_in_as(array('admin','seller'));
		$id = $this->param('id');

		if ($image = Model_Image::find($id))
		{
			$url = 'file/'.$image->belongs_to.'/'.$image->belongs_to_id;
			File::delete(DOCROOT.'uploads/'.$image->url);

			$image->delete();

			Session::set_flash('success', 'Deleted image #'.$id);
			Response::redirect($url);
		}

		else
		{
			Session::set_flash('error', 'Could not delete image #'.$id);
			Response::redirect('yachtshare');
		}



	}
}
