<?php
class Controller_Image extends MyController 
{
	public function before(){
		parent::before();
	}

	public function action_index()
	{
		$data['images'] = Model_Image::find('all');
		$this->template->title = "Images";
		$this->template->links['settings']['current'] = true;
		$this->template->content = View::forge('image/index', $data);

	}

	public function action_view($id = null)
	{
		$data['image'] = Model_Image::find($id);

		is_null($id) and Response::redirect('Image');

		$this->template->title = "Image";
		$this->template->content = View::forge('image/view', $data);

	}

	public function action_create()
	{
		is_null($this->param('boat_id')) and Response::redirect('boat');
		$this->template->links['shares']['current'] = true;

		$data['yachtshare'] = Model_Yachtshare::find($this->param('boat_id'), array('related' => array('images')));

		if (Input::method() == 'POST')
		{
			$val = Model_Image::validate('create');
			
			if ($val->run())
			{
				$image = Model_Image::forge(array(
					'boat_id' => Input::post('boat_id'),
				));

				if ($image and $image->save())
				{
					Session::set_flash('success', 'Added image #'.$image->id.'.');

					Response::redirect('image');
				}

				else
				{
					Session::set_flash('error', 'Could not save image.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		if($this->user->type == 'seller')
		{
			return new Response(View::forge('seller/image_upload', $data));
		}else{
			$this->template->title = "Images";
			$this->template->content = View::forge('image/create',$data);		
		}
	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Image');

		$image = Model_Image::find($id);

		$val = Model_Image::validate('edit');

		if ($val->run())
		{
			$image->boat_id = Input::post('boat_id');

			if ($image->save())
			{
				Session::set_flash('success', 'Updated image #' . $id);

				Response::redirect('image');
			}

			else
			{
				Session::set_flash('error', 'Could not update image #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$image->boat_id = $val->validated('boat_id');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('image', $image, false);
		}

		$this->template->title = "Images";
		$this->template->content = View::forge('image/edit');

	}

	public function action_delete($id = null)
	{
		if ($image = Model_Image::find($id))
		{
			$image->delete();

			Session::set_flash('success', 'Deleted image #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete image #'.$id);
		}

		Response::redirect('image');

	}

	public function action_upload()
	{
		die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
	}

	public function action_upload2()
	{
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		$targetDir = 'uploads/';

		//

		// Get parameters
		$chunk = isset($_REQUEST["chunk"]) ? $_REQUEST["chunk"] : 0;
		$chunks = isset($_REQUEST["chunks"]) ? $_REQUEST["chunks"] : 0;
		$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';

		// Clean the fileName for security reasons
		$fileName = preg_replace('/[^\w\._]+/', '', $fileName);

		// Make sure the fileName is unique but only if chunking is disabled
		if ($chunks < 2 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) {
			$ext = strrpos($fileName, '.');
			$fileName_a = substr($fileName, 0, $ext);
			$fileName_b = substr($fileName, $ext);

			$count = 1;
			while (file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b))
				$count++;

			$fileName = $fileName_a . '_' . $count . $fileName_b;
		}

		// Create target dir
		if (!file_exists($targetDir))
			@mkdir($targetDir);

		// Look for the content type header
		if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
			$contentType = $_SERVER["HTTP_CONTENT_TYPE"];

		if (isset($_SERVER["CONTENT_TYPE"]))
			$contentType = $_SERVER["CONTENT_TYPE"];

		// Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
		if (strpos($contentType, "multipart") !== false) {
			if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
				// Open temp file
				$out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
				if ($out) {
					// Read binary input stream and append it to temp file
					$in = fopen($_FILES['file']['tmp_name'], "rb");

					if ($in) {
						while ($buff = fread($in, 4096))
							fwrite($out, $buff);
					} else
						die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
					fclose($in);
					fclose($out);
					@unlink($_FILES['file']['tmp_name']);


				} else
					die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
			} else
				die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
		} else {
			// Open temp file
			$out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
			if ($out) {
				// Read binary input stream and append it to temp file
				$in = fopen("php://input", "rb");

				if ($in) {
					while ($buff = fread($in, 4096))
						fwrite($out, $buff);

				} else
					die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');

				fclose($in);
				fclose($out);
			} else
				die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		}

		$image = Model_Image::forge(array(
			'boat_id' => $this->param('boat_id'),
			'url' => $fileName,
		));

		$image->save() or 	die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to save to the database."}, "id" : "id"}');

		// Return JSON-RPC response
		die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
	}

}
