#ifndef DICT_SEARCH_H
#define DICT_SEARCH_H

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <errno.h>
#include <iostream>
#include <string>
#include <sys/time.h>

using namespace std;

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
	char word[32];
	int offset;
	int length;
} WORD_IDX;

class dict_lookup
{
	public:
		dict_lookup ();
		~dict_lookup ();
		void load_idx_to_memery ();
		string lookup_dict (string);
	private:
		//解析词典，返回一个DICT_INFO结构体指针
		DICT_INFO *get_dict_info (string info_file);
		//解析每行
		void parse_line (char *line, DICT_INFO * dict_info);
		//Get a OFF_LEN struct of a word.
		void *get_words (string filename, DICT_INFO* dict_info, WORD_IDX * word_idx);
		//Binary search for word's idx information.
		WORD_IDX *get_idx (string word, WORD_IDX * word_idx, DICT_INFO * dict_info);
		inline static int to_int (unsigned char *from_int)
		{
			return *(from_int + 3) + (*(from_int + 2) << 8) + (*(from_int + 1) << 16) + (*from_int << 24);
		}
		string dict_file_name;
		DICT_INFO *dict_info;
		WORD_IDX *idx;
};

#endif
