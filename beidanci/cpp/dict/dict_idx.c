/*
  * dict_idx.c
  * Author:shoru
  * 2009-09-09 12:27
  */

#include <iostream>
#include <stdlib.h>
#include <stdio.h>
#include <string.h>
#include <sys/time.h>
#include "dict_idx.h"
#include "dict_info.h"

using namespace std;

static void *
get_words (char *filename, DICT_INFO * dict_info, WORD_IDX * word_idx)
{
  FILE *fd = fopen (filename, "rb");
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

inline static int
to_int (unsigned char *from_int)
{
  return *(from_int + 3) + (*(from_int + 2) << 8) + (*(from_int + 1) << 16) +
    (*from_int << 24);
}

WORD_IDX *
get_idx (char *word, WORD_IDX * word_idx, DICT_INFO * dict_info)
{
	if (word == NULL || word_idx == NULL || dict_info == NULL)
	{
		return NULL;
	}
	int head = 0, tail = dict_info->wordcount, cur = tail / 2;

	int i = 0;

	while (TRUE)
	{
		int cmp = strcasecmp (word, word_idx[cur].word);
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
	}
}




#ifdef DEBUG

int
main (int argc, char **argv)
{
char suff[30];
struct tm* nowtime;
time_t nt;
nt = time(NULL);
nowtime = localtime(&nt);
strftime(suff, sizeof(suff), "%y%m %T", nowtime);
cout << suff << endl;

  //char *filename = "./stardict-oxford-gb-2.4.2/oxford-gb.idx";
  char *filename = "./stardict-lazyworm-ec-2.4.2/lazyworm-ec.idx";
  //char *dictname = "./stardict-oxford-gb-2.4.2/oxford-gb.dict";
  char *dictname = "./stardict-lazyworm-ec-2.4.2/lazyworm-ec.dict";

  DICT_INFO dict_info;
  //dict_info.wordcount = 39429;
  dict_info.wordcount = 452185;
  //dict_info.idxfilesize = 721264;
  dict_info.idxfilesize = 10106758;
  WORD_IDX *idx =
    (WORD_IDX *) malloc (sizeof (WORD_IDX) * dict_info.wordcount);
  //从.idx文件中读入数据（单词的索引，即在dict文件中的偏移量）
  get_words (filename, &dict_info, idx);

  WORD_IDX *word = get_idx ("man", idx, &dict_info);

  printf ("%s,%d,%d\n", word->word, word->offset, word->length);

  FILE *dict = fopen (dictname, "r");
  if (dict == NULL)
    {
      printf ("dict error\n");
      return -1;
    }
  if (0 != fseek (dict, word->offset, SEEK_SET))
    {
      printf ("seek error\n");
      return -1;
    }

  char explain[word->length + 1];
  memset (explain, '\0', word->length + 1);
  //从.dict文件中读出单词解释
  fread (explain, word->length, 1, dict);

  printf ("%s\n", explain);
  free (idx);

nt = time(NULL);
nowtime = localtime(&nt);
strftime(suff, sizeof(suff), "%y%m %T", nowtime);
cout << suff << endl;

  return EXIT_SUCCESS;
}

#endif /* DEBUG */
