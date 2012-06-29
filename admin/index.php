<?php

	error_reporting(E_ERROR | E_PARSE);

	define("POSTS_DIR", "/Users/aditya/Dev/Github/adityavm.github.com/posts");
	define("META_FILE", ".meta.json");

	chdir(POSTS_DIR);

	if ($handle = opendir(POSTS_DIR)) {
		
		$prev = "";
		$lof = `ls -t`;
		$files = explode("\n", trim($lof));

		$ideas = array();
		$published = array();

		for($i = 0; $i<count($files); $i++){
			if(substr_compare($files[$i], META_FILE, -strlen(META_FILE), strlen(META_FILE)) === 0){

				$j = json_decode(trim(file_get_contents(POSTS_DIR . "/" . $files[$i])), true);
				$mini = array();

				$mini['obj'] = $j;
				$mini['filepath'] = POSTS_DIR . "/" . $j['post_file_name'];
				$mini['metapath'] = POSTS_DIR . "/" . $files[$i];

				if($j['published'])
					$published[] = $mini;
				else
					$ideas[] = $mini;
			}
		}

		closedir($handle);

		if($_GET['new'] == 1){//all new posts are text posts
			$meta = json_decode(stripslashes($_COOKIE['speechhub_post_meta']), true);

			chdir("..");
			$cmd = "/usr/local/bin/speechhub new-post --title=\"{$meta['title']}\"";
			exec($cmd);
			header("Location: index.php");
		}

		if($_GET['save'] == 1){//save this post
			$meta = unserialize(base64_decode($_COOKIE['speechhub_post_meta']));

			if($meta['obj']['published'] == false)://update date in meta if post not published yet
				$meta['obj']['date'] = strftime("%a %b %d %H:%M:%S %Y");
				file_put_contents($meta['metapath'], json_encode($meta['obj']));
			endif;
		}

		if($_GET['publish'] == 1){//publish this post
			$meta = unserialize(base64_decode($_COOKIE['speechhub_post_meta']));

			if($meta['obj']['published'] == false)://update date in meta if post not published yet
				$meta['obj']['date'] = strftime("%a %b %d %H:%M:%S %Y");
				file_put_contents($meta['metapath'], json_encode($meta['obj']));
			endif;

			chdir("..");
			$cmd = "/usr/local/bin/speechhub manage --publish-post {$meta['metapath']}; /usr/local/git/bin/git add *; /usr/local/git/bin/git commit -m \"{$meta['obj']['post_title']} published\";";
			echo "<!--";
			echo $cmd;
			exec($cmd, $arr);
			print_r($arr);
			echo "-->";
			header("Location: index.php#" . $meta['obj']['post_id']);
		}
	}
?>
<html>
<head>
	<script src="jquery.js" type="text/javascript"></script>
	<script src="jquery.cookies.js" type="text/javascript"></script>
	<link href="index.css" rel="stylesheet" type="text/css" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>

<div class="panel ideas">
<h4>Ideas</h4>
<input type="text" class="newpost" placeholder="Type a few words ..."/>
<?
	foreach($ideas as $i=>$v):
		echo ($v['obj']['post_title'] == "") 
	   		? "<a class=\"post\" href=\"edit.php\" data-obj='". base64_encode(serialize($v)) ."'>{$v['obj']['post_slug']}</a>"
	   		: "<a class=\"post\" href=\"edit.php\" data-obj='". base64_encode(serialize($v)) ."'>{$v['obj']['post_title']}</a>";
		//print_r($v);
	endforeach;
?>
</div>
<div class="panel published">
<h4>Published</h4>
<?
	foreach($published as $i=>$v):
		echo "<a id=\"{$v['obj']['post_id']}\" class=\"post\" href=\"edit.php\" data-obj='". base64_encode(serialize($v)) ."'>{$v['obj']['post_title']}</a>";
		//print_r($v);
	endforeach;
?>
</div>
<script type="text/javascript">
$("a.post").on("click", function(){
	$.cookie("speechhub_post_meta", $(this).data("obj"));
	return true;
});

$(".newpost").on("keyup", function(e){
	var obj = {};
	var $this = $(this);
	if(e.keyCode == 13){//return
		obj['title'] = $this.val();
		$.cookie("speechhub_post_meta", JSON.stringify(obj));
		window.location = "index.php?new=1";
	}
});
</script>
</body>
</html>
