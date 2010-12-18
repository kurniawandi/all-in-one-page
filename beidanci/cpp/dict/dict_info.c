/*
 * dict_info.c
 * Author:shoru
 * 2009-08-23 12:54
 */

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <errno.h>
#include "dict_info.h"

/*
 * 将词典的信息文件装入结构体，并返回该结构体指针
 * 失败返回NULL
 */
DICT_INFO *
get_dict_info (char *info_file)
{
  FILE *ifo;
  char *line;
  char buffer[BUFFER_SIZE];

  DICT_INFO *dict_info = (DICT_INFO *) malloc (sizeof (DICT_INFO));

  ifo = fopen (info_file, "r");
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

/*
 * 逐行解析文件，将信息装入特定字段
  */
static void
parse_line (char *line, DICT_INFO * dict_info)
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


#ifdef DEBUG

int
main (int argc, char **argv)
{
  DICT_INFO *tmp = get_dict_info ("./stardict-lazyworm-ec-2.4.2/lazyworm-ec.ifo");
  if (tmp == NULL)
    {
      printf ("error\n");
      exit (EXIT_FAILURE);
    }
  else
    {

    }
  printf ("version:%s", tmp->version);
  printf ("bookname:%s", tmp->bookname);
  printf ("wordcount:%d\n", tmp->wordcount);
  printf ("idxfilesize:%d\n", tmp->idxfilesize);
  printf ("sts:%s\n", tmp->sametypesequence);
  printf ("%s", tmp->other_info);
  free (tmp);
  return EXIT_SUCCESS;
}
#endif /* DEBUG */
