#ifndef DICT_SEARCH_H
#define DICT_SEARCH_H

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <errno.h>
#include <iostream>
#include <sys/time.h>

/*
 * 行缓冲区大小
 */
#define BUFFER_SIZE 500

/*
 * ifo文件后缀
 */
#define IFO_EXT ".ifo"

/*
 * dict info file struct.
 */
typedef struct
{
	char version[100];            //版本
	int wordcount;                //单词数量
	int idxfilesize;              //索引文件大小
	char bookname[100];           //词典名称
	char sametypesequence[10];
	char other_info[1000];        //其他不关心的信息
} DICT_INFO;

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

class dict_lookup
{
	public:
		dict_lookup ();
		~dict_lookup ();
		void load_dict_to_memery ();
	private:
		//解析词典，返回一个DICT_INFO结构体指针
		DICT_INFO *get_dict_info (char *file);
		//解析每行
		static void parse_line (char *line, DICT_INFO * dict_info);
		//Get a OFF_LEN struct of a word.
		static void *get_words (char *filename, DICT_INFO * dict_info, WORD_IDX * word_idx);
		//Binary search for word's idx information.
		WORD_IDX *get_idx (char *word, WORD_IDX * word_idx, DICT_INFO * dict_info0);
		inline static int to_int (unsigned char *from_int);

};

#endif
