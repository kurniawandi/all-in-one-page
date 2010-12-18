/*
  * dict_idx.h
  * Author:shoru
  * 2009-09-09 12:27
  */

#ifndef _DICT_IDX_H
#define _DICT_IDX_H

#include "dict_info.h"
 /*
  * 测试开关
  */
#define DEBUG

#define TRUE 1
 /*
  * idx文件后缀
  */
#define IDX_EXT "idx"

 /*
  * Struct to describe the idx file.
  */
typedef struct
{
  char word[100];
  int offset;
  int length;
} WORD_IDX;

 /*
  * Get a OFF_LEN struct of a word.
  */
static void *get_words (char *filename, DICT_INFO * dict_info,
			WORD_IDX * word_idx);

 /*
  * Binary search for word's idx information.
  */
WORD_IDX *get_idx (char *word, WORD_IDX * word_idx, DICT_INFO * dict_info0);
inline static int to_int (unsigned char *from_int);
#endif /* _DICT_IDX_H */
