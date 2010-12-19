#include <iostream>
#include "include/dict_search.h"
#include "include/ServerSocket.h"

using namespace std;

int main (int argc, char* argv[])
{
	dict_lookup lazy_worm;
	lazy_worm.load_idx_to_memery();
	cout << lazy_worm.lookup_dict("Divorce") << endl;
	return 0;
}


