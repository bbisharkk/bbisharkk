import pytest

from todo import TodoService


def test_add_item_increments_id():
    service = TodoService()
    first = service.add_item("task1")
    second = service.add_item("task2")
    assert first["id"] == 1
    assert second["id"] == 2


def test_add_item_empty_text_raises():
    service = TodoService()
    with pytest.raises(ValueError):
        service.add_item("")
