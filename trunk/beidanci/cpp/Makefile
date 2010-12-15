clean: obj
	rm *.o
obj1: dict_info.o 
	g++ -o info dict_info.o
obj: dict_idx.o 
	g++ -o idx dict_idx.o
dict_idx.o: dict_idx.c
	g++ -c dict_idx.c
dict_info.o: dict_info.c
	g++ -c dict_info.c

