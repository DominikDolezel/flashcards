import json

def load_file(filename):
	with open(filename) as f:
		data = json.load(f)
	return data


def overwrite_file(data, filename):
	with open(filename, "w") as f:
		data = json.dump(data, f, indent=2)

def add_element(thing, filename, id=None, **attributes):
	data = load_file(filename)
	to_add = dict()
	if not id:
		id = len(data[thing]) + 1
	to_add["id"] = id
	for attr, value in attributes.items():
		to_add[attr] = value
	data[thing].append(to_add)
	overwrite_file(data, filename)

print("imported")
