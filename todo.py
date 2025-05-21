class TodoService:
    def __init__(self):
        self._items: list[dict] = []

    def add_item(self, text: str) -> dict:
        if not text:
            raise ValueError("Text cannot be empty")
        item = {"id": len(self._items) + 1, "text": text}
        self._items.append(item)
        return item
