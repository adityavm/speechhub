<?

	error_reporting(E_ERROR | E_PARSE);

	$meta = unserialize(base64_decode($_COOKIE['speechhub_post_meta']));
	$file = file_get_contents($meta['filepath']);
	
	echo "<!--";
		print_r($meta);
	echo "-->"
?>
<html>
<head>
	<script src="jquery.js" type="text/javascript"></script>
	<script src="jquery.cookies.js" type="text/javascript"></script>

	<script src="lib/codemirror.js"></script>
	<link rel="stylesheet" href="lib/codemirror.css">
	<link rel="stylesheet" href="theme/elegant.css">
	<script src="mode/markdown/markdown.js"></script>
	<script src="mode/xml/xml.js"></script>
	<script src="keymap/vim.js"></script>

	<link href="edit.css" rel="stylesheet" type="text/css" />

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<script type="text/javascript">
		function addLink(){
			$(".modal").fadeIn("fast");
		}

		function save(){
			post = $("textarea").val();
			$.post("modifyPost.php", {"text": post}, function(ret){
				console.log("DEBUG: Done!");
				console.log("DEBUG: ", ret);
				window.location = "index.php?save=1#<? echo $meta['obj']['post_id'] ?>";
			}, 'json');
		}

		function publish(){
			post = $("textarea").val();
			$.post("modifyPost.php", {"text": post}, function(ret){
				console.log("DEBUG: Done!");
				console.log("MEBUG: ", ret);
				window.location = "index.php?publish=1#<? echo $meta['obj']['post_id'] ?>";
			}, 'json');
		}
	</script>
</head>
<body>
<div class="post">
	<a href="index.php" class="return">&larr;</a><h1><? echo $meta['obj']['post_title']; ?></h1>
	<div class="md-e">
		<img src="images/markdown.png" /><br/>
		<span class="hint">This editor accepts <a href="http://daringfireball.net/projects/markdown/">Markdown</a>.</span>
	</div>
	<textarea><? echo $file; ?></textarea>

	<a class="button" onclick="javascript:addLink();">Add Link</a>
	<div class="bounding">
		<a class="button <? echo ($meta['obj']['published']) ? "" : "on"; ?>" onclick="javascript:save();"><span>Idea</span></a>
		<a class="button <? echo ($meta['obj']['published']) ? "on" : ""; ?>" onclick="javascript:publish();"><span>Published</span></a>
	</div>
</div>

<div class="modal">
	<div class="box">
		<p>Add a link to make this a link post. Leave the box blank to make this a text post.</p>
		<input type="text" id="post_link" placeholder="Insert link here ..." value="<? echo $meta['obj']['post_link'] ?>" />
	</div>
</div>

<script type="text/javascript">
	var myCodeMirror = CodeMirror.fromTextArea($("textarea")[0], {
		"theme": "elegant",
		"indentWithTabs": true,
		"keyMap": "vim",
	});

	$("#post_link").on("keyup", function(e){
		var $this = $(this);

		if(e.keyCode == 13){
			$.getJSON("modifyPost.php", {"link": $this.val()}, function(ret){
				console.log("DEBUG: Done!");
				console.log("DEBUG: ", ret);

				$(".modal").fadeOut("fast");
			});
		}
	})

	$(".modal").on("click", function(){ $(this).fadeOut("fast"); });
	$(".modal .box").on("click", function(){ return false; });
</script>
</body>
</html>
