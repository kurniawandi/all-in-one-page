#include <iostream>
#include <exception>
#include "dict_search.h"

using namespace std;

dict_lookup::dict_lookup ()
{
	dict_file_name = "./dict_lazyworm_ec/lazyworm-ec.";
}

dict_lookup::~dict_lookup ()
{
	free(dict_info);
	free(idx);
}

void dict_lookup::load_idx_to_memery ()
{
	//get_dict_info返回的是malloc出来的那段内存的首地址
	dict_info = get_dict_info (dict_file_name + "ifo");
	if (dict_info == NULL)
	{
		printf ("error\n");
		exit (EXIT_FAILURE);
	}
	else
	{
		idx = (WORD_IDX *) malloc (sizeof (WORD_IDX) * dict_info->wordcount);
		//从.idx文件中读入数据（单词的索引，即在dict文件中的偏移量）
		get_words (dict_file_name + "idx", dict_info, idx);
	}
}

string dict_lookup::lookup_dict (string unknown_word)
{
	WORD_IDX *word = get_idx (unknown_word, idx, dict_info);

	if ( NULL == word)
	{
		return "NOTFOUND";
	}

	string dictname = dict_file_name + "dict";
	FILE *dict = fopen (dictname.c_str(), "r");
	if (dict == NULL)
	{
		printf ("dict error\n");
		return "NOTOPEN";
	}
	if (0 != fseek (dict, word->offset, SEEK_SET))
	{
		printf ("seek error\n");
		return "NOTFOUND";
	}

	char explain[word->length + 1];
	memset (explain, '\0', word->length + 1);
	//从.dict文件中读出单词解释
	fread (explain, word->length, 1, dict);
	string result(explain);
	return result;
}


DICT_INFO* dict_lookup::get_dict_info (string info_file)
{
	FILE *ifo;
	char *line;
	char buffer[BUFFER_SIZE];

	DICT_INFO *dict_info = (DICT_INFO *) malloc (sizeof (DICT_INFO));

	ifo = fopen (info_file.c_str(), "r");
	if (ifo == NULL)
	{
		fprintf (stderr, "%s", strerror (errno));
		return NULL;
	}

	while ((line = fgets (buffer, BUFFER_SIZE, ifo)) != NULL)
	{
		parse_line (line, dict_info);
	}
	fclose (ifo);

	return dict_info;
}

void dict_lookup::parse_line (char *line, DICT_INFO * dict_info)
{
	char *idx;
	if ((idx = strchr (line, '=')) != NULL)
	{
		if (strstr (line, "version") != NULL)
		{
			strcpy (dict_info->version, idx + 1);
		}
		else if (strstr (line, "wordcount") != NULL)
		{
			dict_info->wordcount = atoi (idx + 1);
		}
		else if (strstr (line, "idxfilesize") != NULL)
		{
			dict_info->idxfilesize = atoi (idx + 1);
		}
		else if (strstr (line, "bookname") != NULL)
		{
			strcpy (dict_info->bookname, idx + 1);
		}
		else if (strstr (line, "sametypesequence") != NULL)
		{
			strcpy (dict_info->sametypesequence, idx + 1);
		}
		else
		{
			strcat (dict_info->other_info, line);
		}
	}
}

void* dict_lookup::get_words (string filename, DICT_INFO * dict_info, WORD_IDX * word_idx)
{
	FILE *fd = fopen (filename.c_str(), "rb");
	size_t nread = 0;

	if (fd == NULL || dict_info == NULL)
	{
		return NULL;
	}
	unsigned char buffer[dict_info->idxfilesize];

	nread = fread (buffer, dict_info->idxfilesize, 1, fd);

	unsigned char *head, *tail;
	head = tail = buffer;
	int it = 0;
	int total = 1;
	for (; it < dict_info->idxfilesize; it++)
	{
		if (*head == '\0')
		{
			strncpy ((word_idx + total)->word, (const char*)tail, head - tail + 1);
			(word_idx + total)->offset = to_int (head + 1);
			(word_idx + total)->length = to_int (head + 5);
			total++;
			head += 9;
			tail = head;
			if (total == dict_info->wordcount)
				break;
		}
		else
		{
			head++;
			continue;
		}
	}
}

//bug:当查不存在单词的index的时候，进入无限循环中
WORD_IDX* dict_lookup::get_idx (string word, WORD_IDX * word_idx, DICT_INFO * dict_info)
{
	if (word == "" || word_idx == NULL || dict_info == NULL)
	{
		return NULL;
	}
	int head = 0, tail = dict_info->wordcount, cur = tail / 2;

	int i = 0;

	while (TRUE)
	{
		int cmp = strcasecmp (word.c_str(), word_idx[cur].word);
		if (0 == cmp)
		{
			return &word_idx[cur];
		}
		else if (0 > cmp)
		{
			tail = cur;
		}
		else
		{
			head = cur;
		}
		cur = (tail + head) / 2;
		if (head == cur)
		{
			return NULL;
		}
	}
}

