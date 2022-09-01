from file_handling import load_file, overwrite_file, add_element

def parse(data):
	final = {}
	cards = data["cards"]
	cards = cards.split("\n")
	number = 1
	for card in cards:
		if "--" in card:
			c = card.split("--")
			words = c[0].split(";")
			final[str(number)] = {"id": number, "question": "", "term": words[0], "definition": words[1], "images": c[1].split(";")}
		else:
			words = card.split(";")
			final[str(number)] = {"id": number, "question": "", "term": words[0], "definition": words[1], "images": []}
		number += 1
	return final

def main():

	data_old = load_file("cards_to_save.json")

	data = data_old["to_save"][-1]

	cards = parse(data)
	name = data["name"]

	description = data["description"]
	author_id = data["author_id"]
	source = load_file("data.json")


	if source["sets"] == []:
		set_id = 1
	else:
		print(int(source["sets"][-1]["id"]))
		set_id = int(source["sets"][-1]["id"]) + 1
		print("here")
	source["sets"].append({"id": set_id, "cards": cards, "description": description, "name": name, "author_id": author_id})
	print("here")
	print("here")
	overwrite_file(source, "data.json")
	print("finished")

main()
