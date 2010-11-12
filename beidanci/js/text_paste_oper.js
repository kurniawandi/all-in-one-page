$(":submit").click( function (event) {
	event.preventDefault();
	//单词处理
	var text_data = $("textarea").val();
	var selected_level = $("select option:selected").attr("value");
	if (text_data != "" && text_data != undefined)
	{
		$("div#stat_result").empty();
		$("div#stat_result").text("Loading...");
		selected_level = selected_level.substring(5);
		//alert(selected_level);
		text_data = text_data.toLowerCase();
		//x = new Date();
		//去文本中的非字母符号、下划线、数字
		text_data = text_data.replace(/[\W_\d]+/g , " ");
		//去掉单个的字母
		text_data = text_data.replace(/\b.\b/g , " ");
		//去掉首尾空格
		//text_data = text_data.replace(/^\s+|\s+$/g , "");
		//去连续的空格
		text_data = text_data.replace(/\s+/g , " ");
		//然后trim前后一个空格就好
		if (text_data[0] == " ")
		{
			if (text_data[text_data.length-1] == " ")
			{
				text_data = text_data.substring(1, text_data.length-1);
			}
			else
			{
				text_data = text_data.substring(1);
			}
		}
		else
		{
			if (text_data[text_data.length-1] == " ")
			{
				text_data = text_data.substring(0, text_data.length-1);
			}
		}

		/*
		y = new Date();  
		diff = y.getTime() - x.getTime(); 
		alert("载入本页共用了 " + diff/1000 + " 秒"); 
		alert(text_data); 
		return;
		*/
		$.ajax({
			type: "POST",
			url: "http://" + server_address + "/beidanci/words_filter.php",
			data: { text : text_data, selected : selected_level },
			//error can do a lot of work! try to connect like google.
			//in function ajax can do recursively until connected to server.
			error: function(XMLHttpRequest, textStatus, errorThrown){ 
				alert(textStatus);
				alert(errorThrown);
			},
			success: function (xml) {
				//alert(xml);
				//取出传过来的最后一个level的id
				var last_level = parseInt($("level:last", xml).attr("id"));
				$("div#stat_result").empty();
				$("div#stat_result").append(show_statistic_result(xml, last_level));
				$("div.content").hide();
				//只show最难级别的
				$("div#level" + last_level + "_content").show();
				translate_table(last_level);
				$("textarea").focus();
			}//end of success
		});//end of ajax
	}//end of if
});//end of submit action
$("a.hid_button").live("click", function (event) {
	var divid = "div#level"+$(this).parent().attr("id")+"_content";
	$("div.content").slideUp();
	$(divid).show();
	event.preventDefault();
});
$(".all_translate").live ("click", function (event) {
	translate_table($(this).parent().parent().attr("id").substring(5, 6));
	event.preventDefault();
});
$(".unknown").live ("click", function (event) {
	$(this).parent().parent().find("td.trans").empty();
	$(this).parent().parent().find("td.trans").text("Loading...");
	var trans_word = $(this).attr("id").split("@")[0];
	//alert(trans_word);
	translate_word(trans_word, $(this).parent().parent().find("td.trans"));
	var level_id = $(this).parent().parent().parent().parent().attr("id").substring(5, 6);
	$.ajax({
		type: "POST",
		url: "http://" + server_address + "/beidanci/record_difficulty.php",
		data: { word : trans_word, level : level_id },
		//error can do a lot of work! try to connect like google.
		//in function ajax can do recursively until connected to server.
		error: function(){ alert("Network error."); },
		success: function (xml) {
		}//end of success
	});//end of ajax
	event.preventDefault();
});
$(".add_to_lib").live ("click", function (event) {
	var add_word = $(this).attr("id").split("@")[0];
	var this_button = $(this);
	this_button.attr("disabled", "true");
	$.ajax({
		type: "POST",
		url: "http://" + server_address + "/beidanci/add_to_word_book.php",
		data: { word : add_word },
		//error can do a lot of work! try to connect like google.
		//in function ajax can do recursively until connected to server.
		error: function() { alert("Network error."); },
		success: function (xml) {
			//trim这一步是必须的
			xml = $.trim(xml);
			//alert (xml);
			if ( "OK" == xml )
			{
				//
			}
			else if ( "ERROR" == xml )
			{
				this_button.attr ("disabled", "");
			}
			else if ( "EXIST" == xml )
			{
				this_button.attr ("disabled", "");
			}
			else if ( "NOTLOGGEDIN" == xml )
			{
				$("#log_reg").dialog();
				this_button.attr ("disabled", "");
			}
		}//end of success
		//加入哪个生词本
	});//end of ajax
	event.preventDefault();
});
$(".add_to_known").live ("click", function (event) {
	var known_word = $(this).attr("id").split("@")[0];
	var this_button = $(this);
	$.ajax({
		type: "POST",
		url: "http://" + server_address + "/beidanci/add_to_known.php",
		data: { word : known_word },
		//error can do a lot of work! try to connect like google.
		//in function ajax can do recursively until connected to server.
		error: function(XMLHttpRequest, textStatus, errorThrown) { 
			alert(textStatus);
			alert(errorThrown);
		},
		success: function (xml) {
			//trim这一步是必须的
			xml = $.trim(xml);
			if ( xml == "OK" )
			{
				this_button.parent().parent().fadeOut("slow");
				//将剩余单词数减一
				$("span#remain").text( parseInt($("span#remain").text()) - 1 );
			}
			else
			{
				$("#hint_tips").text("忽略失败，请稍候再试。");
			}
		}//end of success
	});//end of ajax
});
$(window).keydown(function(event) {
	//alert(event.keyCode);
	switch(event.keyCode) {
		// ...
		// 不同的按键可以做不同的事情
		// 不同的浏览器的keycode不同
		// 更多详细信息:     http://unixpapa.com/js/key.html
		// ...
		case 191 : {
			if (document.activeElement.tagName != "TEXTAREA")
			{
				//alert(event.keyCode);
				$("textarea").focus();
				event.preventDefault();
			}
		}
	}
});


