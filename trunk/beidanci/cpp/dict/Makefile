main_object = main.o dict_search.o ServerSocket.o Socket.o

clean: obj
	rm *.o

obj: $(main_object)
	g++ -o 1main $(main_object)

main.o: main.cpp
	g++ -c main.cpp
dict_search.o: ./include/dict_search.cpp
	g++ -c ./include/dict_search.cpp
ServerSocket.o: ./include/ServerSocket.cpp
	g++ -c ./include/ServerSocket.cpp
Socket.o: ./include/Socket.cpp
	g++ -c ./include/Socket.cpp
