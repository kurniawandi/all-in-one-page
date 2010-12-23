#include <iostream>
#include <string>
#include "include/dict_search.h"
#include "include/ServerSocket.h"
#include "include/SocketException.h"

using namespace std;

string xml_wrapper (string key, string str/*key的发音和解释*/)
{
	string result = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?><dict><key>" + key + "</key><pron>";
	int pos = str.find_first_of("\n");
	result += str.substr(0, pos) + "</pron><def>";
	int found = str.find_first_of("\n");
	while ( found != string::npos )
	{
		str[found] = ' ';
		found=str.find_first_of("\n",found+1);
	}
	result += str.substr(pos) + "</def>";
	result += "</dict>";
	return result;
}

int main (int argc, char* argv[])
{
	dict_lookup lazy_worm;
	lazy_worm.load_idx_to_memery();
	cout << lazy_worm.lookup_dict("Divorce") << endl;
	cout << xml_wrapper("divorce", lazy_worm.lookup_dict("Divorce"));
	cout << endl;
	try
	{
		// Create the socket
		ServerSocket server ( 30000 );

		while ( true )
		{
			ServerSocket new_sock;
			server.accept ( new_sock );
			cout << "came1" << endl;

			try
			{
				//while ( true )
				{
					std::string data;
					new_sock >> data;
			cout << "came2" << endl;
					cout << data << endl;
					new_sock << xml_wrapper(data, lazy_worm.lookup_dict(data));
					cout <<  xml_wrapper(data, lazy_worm.lookup_dict(data)) << endl;
			cout << "came3" << endl;
				}
			}
			catch ( SocketException& e ) 
			{
				std::cout << "Exception was caught:" << e.description() << "\nExiting.\n";
			}
		}
	}
	catch ( SocketException& e )
	{
		std::cout << "Exception was caught:" << e.description() << "\nExiting.\n";
	}

	return 0;
}


