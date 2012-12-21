<?php

class Controller_File extends MyController
{
	public function action_index()
	{
		//$this->logged_in_as(array('admin','seller'));

		if(is_null($this->param('item')) || !in_array($this->param('item'), array('yachtshare','buyer')))
			throw new HttpNotFoundException;

		$id = $this->param('id');

		if($this->param('item') == 'yachtshare')
		{
			$data['item'] = Model_Yachtshare::find($id);

			if(!$data['item'])
				throw new HttpNotFoundException;

			$data['type'] = 'yachtshare';
			$this->template->title = "Yachtshare: ".$data['item']->name;
			$this->template->links['shares']['current'] = true;
		}else{
			$data['item'] = Model_Buyer::find($id);

			if(!$data['item'])
				throw new HttpNotFoundException;

			$data['type'] = 'buyer';
			$this->template->title = "Buyer: ".$data['item']->name;
			$this->template->links['buyers']['current'] = true;
		}

		$data['files'] = Model_Image::find('all', array('where' => array('belongs_to' => $data['type'], 'belongs_to_id' => $id)));

		if(isset($this->user) and $this->user->type == 'admin')
		{
			$this->template->content = View::forge('file/index',$data,false);				
		}else{
			$this->template = \View::forge('public_template',array(),false);
			//$this->template->user = $this->user;
			$this->template->title = 'Yacht Fractions: Seller Panel';
			$this->template->content = View::forge('file/seller/index',$data,false);	
		}

	}

/* Whats inside Input::file():
Array
        (
            [name] => Man___Nature_by_chaneljay.jpg
            [type] => image/jpeg
            [tmp_name] => /tmp/phppxtQef
            [error] => 0
            [size] => 1180805
        )


Also, whats inside Upload::get_files() as $file:
Array
(
    [name] => Man___Nature_by_chaneljay.jpg
    [type] => image/jpeg
    [error] => 
    [size] => 1180805
    [field] => file
    [file] => /tmp/phpWdc7Zb
    [errors] => Array
        (
        )

    [extension] => jpg
    [filename] => Man___Nature_by_chaneljay
    [mimetype] => image/jpeg
    [saved_to] => /home/evan/www/yacht/public/uploads/
    [saved_as] => 90014aed5ba8af8d70bef0eed6f05af5.jpg
)

Also each file can be of the type:

	1. Private file				"private_file"
	2. Public header image		"public_header"
	3. Public gallery image		"public_gallery"
*/
	public function action_upload()
	{
		//$this->logged_in_as(array('admin','seller'));
		if(Input::method() == 'POST')
		{
		//0. Check that a file has been inputted
			$input_file = Input::file('file');
			$file_name = $input_file['name'];
			if(empty($file_name))
			{
				Session::set_flash('error', 'Please follow the instructions and select a file by clicking the [+] button next to the "Select a File:" row.');	
				Response::redirect('file/'.Input::post('belongs_to').'/'.Input::post('belongs_to_id'));
			}
		//0.1. Check that a file type has been selected
			$type = Input::post('type');
			if(empty($type))
			{
				Session::set_flash('error', 'Please follow the instructions and select a file type from the dropdown in the form below.');	
				Response::redirect('file/'.Input::post('belongs_to').'/'.Input::post('belongs_to_id'));
			}


		//1. process the uploaded files in $_FILES

			$config = array(
				'path' => DOCROOT.'uploads',
				'randomize' => true,
			);

			//Save as file name: yachtshare_id_+_num_+.*
			Upload::register('before', function (&$file) {
				//2. Find the total number of other files for this item
				$files_in_db = Model_Image::find('all', array('where' => array('belongs_to' => Input::post('belongs_to'), 'belongs_to_id' => Input::post('belongs_to_id'))));;
				$num = count($files_in_db);
				if ($file['error'] == Upload::UPLOAD_ERR_OK)
				{
					$file['saved_as'] = Input::post('belongs_to').'_id_'.Input::post('belongs_to_id').'_num_'.($num+1).'_'.Input::post('type').'.'.$file['extension'];
				}
			});

			Upload::process($config);

		//2. Check for errors

				$errors = Upload::get_errors();				
				$max_upload_size = (int)(ini_get('upload_max_filesize'));

				//If there are errors then display the error message in flash session
				//and redirect to the upload form
				if(count($errors) > 0)
				{
					$error_message = $errors[0]['errors'][0]['message'];
					Session::set_flash('error', 'Your '.$type_arr[0].' was not uploaded due to an error: '.$error_message.'. The max file size limit is: '.$max_upload_size.' MB');	
					Response::redirect('file/'.Input::post('belongs_to').'/'.Input::post('belongs_to_id'));
				}

		//3. Otherwise upload them to the public/assets/uploads directory
			(Upload::is_valid()) and Upload::save();

			foreach(Upload::get_files() as $file)
			{
				//4. Resize if the file is an image with width > 800px
				$file_loc = $file['saved_to'].$file['saved_as'];


				//IF it is an image
				$mime_arr = explode('/',$file['mimetype']);
				if($mime_arr[0] == 'image')
				{
					$sizes = Image::sizes($file_loc);

					//IF it is too big
					if($sizes->width > 800)
					{
						Image::load($file_loc)->resize(800)->save($file_loc);
					}
				}

				//5. Insert the file details into DB
				$public = (Input::post('type') == 'private') ? 0 : 1;

				if(Input::post('belongs_to') == "yachtshare")
				{
					$yachtshare = Model_Yachtshare::find(Input::post('belongs_to_id'));

					if($yachtshare->group_ids != null)
					{
						$belongs_to_ids = explode(',',$yachtshare->group_ids);						
					}else{
						$belongs_to_ids = array(Input::post('belongs_to_id'));
					}
				}else{
					$belongs_to_ids = array(Input::post('belongs_to_id'));
				}

				$errors = 0;

				foreach($belongs_to_ids as $id)
				{
					$file_db = Model_Image::forge(array(
						'belongs_to_id' => $id,
						'belongs_to' => Input::post('belongs_to'),
						'public_image' => $public,
						'url' => $file['saved_as'],
						'type' => Input::post('type'),
					));

					$file_db->save() or $errors++;	
				}

				if($errors == 0)
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
