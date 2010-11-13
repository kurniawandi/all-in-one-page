
/*
输入当前页和总页数，返回翻页的html代码

首页 | 上一页 | 1 2 3 4 5 6 ... 99 100 | 下一页 | 尾页
如果总页数小于10，全部显示出来
首页 | 上一页 | 1 2 3 4 5 6 7 8 9 10 | 下一页 | 尾页
<div id="page_button">
首页 | 上一页 | <a id="">[1]<a> <a id="2" href="">[2]</a> [3] [4] [5] [6] [7] [8] [9] [10] |<a id="2" href="">下一页</a> | 尾页
</div>
否则显示6+...+2条
首页 | 上一页 | 1 2 3 4 5 6 ... 10 11 | 下一页 | 尾页
首页 | 上一页 | <a>4</a> <a>5</a> 6 <a>7</a> <a>8</a> <a>9</a> ... 99 100 | 下一页 | 尾页
*/
function page_index_button_html (current_page_index, page_count)
{
	var page_button = "<div id=\"page_button\">";
	//alert(current_page_index);
	//alert(page_count);
	//if (page_count < 10)
	{
		//把它初始化成空字符串很重要，否则它就是undefined
		var page_index_link = "";
		if (current_page_index == 1)
		{
			page_button += "首页|上一页| ";
			//alert(page_button);
		}
		else
		{
			var prev_id = current_page_index - 1;
			//alert(prev_id);
			page_button += "<a id=\"1\" href=\"\">首页</a>|<a id=\"" + prev_id + "\" href=\"\">上一页</a>| ";
		}
		for (var i = 1; i <= page_count; i++)
		{
			if (i === current_page_index)
			{
				//page_index_link += "<a id=\"current_page\">[" + i + "]</a>&nbsp;";
				page_index_link += "[" + i + "]&nbsp;";
			}
			else
			{
				page_index_link += "<a id=\"" + i + "\" href=\"\">[" + i + "]</a>&nbsp;";
			}
		}
		//alert(page_index_link);
		page_button += page_index_link;
		if ( current_page_index == page_count )
		{
			page_button += "|下一页|尾页";
		}
		else
		{
			var next_id = current_page_index + 1;
			//next_id = next_id - 0;
			next_id = next_id + "";
			//alert( typeof next_id );
			page_button += "|<a id=\"" + next_id + "\" href=\"\">下一页</a>|<a id=\"" + page_count + "\" href=\"\">尾页</a></div>"
		}
		//alert(page_button);
	}
	return page_button;
}


/*
为不同后缀的单词建表
*/
function make_table_from_xml_to_html (xml, suffix, operation)
{
	var word_table = "<table id=\"word_table\"><tr class=\"header\"><th>Word Transform</th><th colspan=\"2\">Operation</th></tr>";
	var table_rows = "";
	var full_word = "";
	var line = "odd";
	var hint_array = operation.split("@");
	$(xml).find("word").each (function () {
		//alert("hehe");
		full_word = $(this).text();
		//alert(full_word);
		table_rows += "<tr class=\"" + line + "\"><td width=\"400\">" + hint_array[0];
		table_rows += full_word.substring(0, full_word.length - suffix.length);
		table_rows += " + " + suffix + "变" + hint_array[1] + full_word + "</td>";
		table_rows += "<td width=\"40\"><a id=\"" + $(this).text() + "\" href=\"\">False</a></td><td width=\"40\">True</td></tr>";
		line=="odd" ? line = "even" : line = "odd";
	});
	//alert ( table_rows );
	word_table += table_rows + "</table>";
	//alert ( word_table );
	return word_table;
}

//用户将单词加入到生词本的按钮
function add_to_lib_button_html (which_word)
{
	return "<input type=\"button\" id=\"" + which_word + "@wordbook\" class=\"add_to_lib\" value=\"加入生词本\" />";
}

//用户记录不需要统计的单词
function add_to_known_button_html (which_word)
{
	return "<input type=\"button\" id=\"" + which_word + "@known\" class=\"add_to_known\" value=\"忽略统计\" />";
}

function translate_unknown_button_html (which_word)
{
	return "<input type=\"button\" id=\"" + which_word + "@trans\" class=\"unknown\" value=\"翻译\" />";
}

function show_statistic_result (xml, last_level)
{
	var res_html = new Array();//每个级别的html保存在这个数组的一个元素中
	var j = 1;
	//每个循环建一个表
	$(xml).find("level").each (function () {
		var this_id = $(this).attr("id");//取值为0-7
		res_html[j] = "<div id=\"level" + this_id + "_container\">";
		res_html[j] += "<div id=\"" + this_id + "\" class=\"tab_bar\">";
		if (this_id == last_level)
		{
			res_html[j] += "<a class=\"hid_button\" href=\"\">过滤后剩下单词";
			res_html[j] += "<span id=\"remain\">"+ $(this).attr("amount") + "</span>个：</a>";
		}
		else
		{
			res_html[j] += "<a class=\"hid_button\" href=\"\">+过滤掉的难度级别为" + this_id + "的单词共" + $(this).attr("amount") + "个：</a>";
		}
		res_html[j] += "</div><!--end of x tab_bar-->";
		res_html[j] += "<div id=\"level" + this_id + "_content\" class=\"content\">";
		res_html[j] += "<div class=\"operation_bar\">";
		res_html[j] += "<input type=\"button\" class=\"all_translate\" value=\"翻译所有单词\" />";
		res_html[j] += "<input type=\"button\" class=\"all_add_to_lib\" value=\"将所有单词加入生词本\" />";
		res_html[j] += "</div><!--end of operation_bar-->";
		res_html[j] += "<table id=\"level" + this_id + "\" border=\"0\">";
		res_html[j] += "<tr class=\"header\"><th>Word</th><th>Translation</th><th>Frequency</th><th>Operation</th></tr>";
		var row_array = new Array();
		var i = 0;
		//将行的html放入到数组中
		//每个循环得到一个行
		$(this).find("word").each (function () {
			if (last_level != this_id)
			{
			row_array[i] = "<tr><td class=\"w\" width=\"160\">" + $(this).text() + "</td>";
			row_array[i] += "<td class=\"trans\">None</td>";
			row_array[i] += "<td class=\"f\">" + $(this).attr("frequency") + "</td>";
			row_array[i] += "<td class=\"o\">" + translate_unknown_button_html($(this).text()) + "</td></tr>";
			}
			else
			{
			row_array[i] = "<tr><td class=\"w\" width=\"160\">" + $(this).text() + "</td>";
			row_array[i] += "<td class=\"trans\">Loading...</td>";
			row_array[i] += "<td class=\"f\">" + $(this).attr("frequency") + "</td>";
			row_array[i] += "<td class=\"o\">" + add_to_lib_button_html($(this).text());
			row_array[i] += add_to_known_button_html($(this).text()) + "</td></tr>";
			}
			i++;
		});
		//给行排序
		row_array.sort(function (a, b) {
			return parseInt($("td.f", b).text()) - parseInt($("td.f", a).text());
			//return parseInt($(a).find(".f").text()) - parseInt($(b).find(".f").text());
		});
		//将行的html写入表内
		res_html[j] += row_array.join("");
		res_html[j] += "</table>";
		res_html[j] += "</div><!--end of level_content-->";
		res_html[j] += "</div><!--end of levelx_container-->";
		j++;
	});
	res_html.reverse();//数组反序
	return res_html.join("");
}


function ShellSort(arr) { //插入排序->希儿排序
	var st = new Date();
	var increment = arr.length;
	do {
		increment = (increment/3|0) + 1;
		arr = ShellPass(arr, increment);
	}
	while (increment > 1)

	//alert((new Date() - st) + ' ms');
	return arr;
}

function ShellPass(arr, d) { //希儿排序分段执行函数
	var temp, j;
	for(var i=d; i<arr.length; i++) {
		if((arr[i]) > (arr[i-d])) {	//降序
			temp = arr[i]; j = i-d;
			do {
				arr[j+d] = arr[j];
				j = j-d;
			}
			while (j>-1 && (temp) > (arr[j]));	//降序
			arr[j+d] = temp;
		}//endif
	}
	return arr;
}

