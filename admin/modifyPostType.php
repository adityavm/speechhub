<?
	//error_reporting(E_ERROR | E_PARSE);

	$meta = unserialize(base64_decode($_COOKIE['speechhub_post_meta']));
	
	if($_GET['link'] == ""){//text post
		$meta['obj']['post_type'] = "text";
		$meta['obj']['post_link'] = "";
	} else {
		$meta['obj']['post_type'] = "link";
		$meta['obj']['post_link'] = $_GET['link'];
	}

	// rewrite the meta file
	file_put_contents($meta['metapath'], json_encode($meta['obj']));
	setcookie("speechhub_post_meta", base64_encode(serialize($meta)));
	echo json_encode(array("success"=>"true"));
?>
