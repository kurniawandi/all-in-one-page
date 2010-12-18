/*
 * dict_info.h
 * Author:shoru
 * 2009-08-23 12:53
 */

#ifndef _DICT_IFO_H
#define _DICT_IFO_H

/*
 * 测试开关
 */
#define DEBUG

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
  char version[100];		//版本
  int wordcount;		//单词数量
  int idxfilesize;		//索引文件大小
  char bookname[100];		//词典名称
  char sametypesequence[10];
  char other_info[1000];	//其他不关心的信息
} DICT_INFO;

/*
 * 解析词典，返回一个DICT_INFO结构体指针
 */
DICT_INFO *get_dict_info (char *file);

/*
 * 解析每行
 */
static void parse_line (char *line, DICT_INFO * dict_info);

#endif /* _DICT_IFO_H */
