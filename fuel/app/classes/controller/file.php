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

/* Whats inside $tmp_file:
Array
        (
            [name] => Man___Nature_by_chaneljay.jpg
            [type] => image/jpeg
            [tmp_name] => /tmp/phppxtQef
            [error] => 0
            [size] => 1180805
        )
*/
	public function action_upload()
	{
		$this->logged_in_as(array('admin','seller'));
		if(Input::method() == 'POST')
		{
		//1. process the uploaded files in $_FILES

				$config = array(
					'path' => DOCROOT.'uploads',
					'randomize' => true,
				);
				Upload::process($config);

		//2. Check for errors

				$errors = Upload::get_errors();				
				$max_upload_size = (int)(ini_get('upload_max_filesize'));

				//If there are errors then display the error message in flash session
				//and redirect to the upload form
				if(count($errors) > 0)
				{
					$error_message = $errors[0]['errors'][0]['message'];
					Session::set_flash('error', 'Your '.$type_arr[0].' was not uploaded due to an error: '.$error_message.'. The max file size limit is: '.$max_upload_size);	
					Response::redirect('file/'.Input::post('belongs_to').'/'.Input::post('belongs_to_id'));
				}

		//3. Resize if the file is an image with width > 800px
			$tmp_file = Input::file();
			$tmp_file = $tmp_file['file'];
			$tmp_file_loc = $tmp_file['tmp_name'];
			exit($tmp_file_loc);
			//IF it is an image
			$mime_arr = explode('.',$tmp_file['name']);
			if(in_array(strtolower($mime_arr[1]),array('jpg','png','gif')))
			{
				//exit($file_loc);

				$sizes = Image::sizes($tmp_file_loc);

				//IF it is too big
				if($sizes->width > 800)
				{
					Image::load($tmp_file_loc)->resize(800)->save($tmp_file_loc);
						//exit("COULD NOT RESIZE!");
				}
			}

		//3. Otherwise upload them to the public/assets/uploads directory
			(Upload::is_valid()) and Upload::save();

			foreach(Upload::get_files() as $file)
			{
		//4. Insert the file details into DB
				$type_arr = explode("/", $file['mimetype']);
				$public = (Input::post('public_image')) ? 1 : 0;

				$file_db = Model_Image::forge(array(
					'belongs_to_id' => Input::post('belongs_to_id'),
					'belongs_to' => Input::post('belongs_to'),
					'public_image' => $public,
					'url' => $file['saved_as'],
					'type' => $type_arr[0],
				));
				
				exit("DONE");

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
