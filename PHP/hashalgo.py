import sys

class Node:
    # Represents a node in the linked list
    def __init__(self, key, value):
        self.key = key
        self.value = value
        self.next = None

class Hashtable:
    # Actual table containing the array holding the linked list
    # Allows methods to insert, retrieve, and delete data from the hash table
    def __init__(self, size):
        # Initialization
        self.size = size  # Capacity of the hashtable
        self.slots = [None] * self.size  # Indicating size

    def append_to_table(self, key, data):
        # Append data to the hashtable
        hashing_value = self._hashing_algorithm(key, len(self.slots))

        if self.slots[hashing_value] is None:
            # If slot is empty
            self.slots[hashing_value] = Node(key, data)
        else:
            # If slot is not empty, handle collision by chaining
            current = self.slots[hashing_value]
            while current.next is not None and current.key != key:
                current = current.next
            if current.key == key:
                # If key exists, replace the data
                current.value = data
            else:
                # If key does not exist, append new node
                current.next = Node(key, data)

    def _hashing_algorithm(self, key, size):
        # Hashing algorithm
        hashing_value = 0
        for character in key:
            hashing_value = (hashing_value * 198 + ord(character)) % size
        return hashing_value

def receive_from_php(filename):
    # Receive data from PHP
    with open(filename, 'r') as received_text:
        password = received_text.read().strip()
        hashtable = Hashtable(100)  # Initialize hashtable with size 100
        hashtable.append_to_table("password", password)  # Example: key="password"
        return password  # Return hashed password or other processed data

if __name__ == "__main__":
    # Main function
    if len(sys.argv) != 2:
        print("Usage: python script_name.py <filename>")
        sys.exit(1)

    filename = sys.argv[1]
    result = receive_from_php(filename)
    print("Processed data:", result)
