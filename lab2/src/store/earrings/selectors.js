export const fetchItems = (store) => {
  const { dispatch } = store;
  dispatch('earrings/fetchItems');
};

export const selectItems = (store) => {
  const { getters } = store;
  return getters['earrings/items']
}

export const removeItem = (store, id) => {
  const { dispatch } = store;
  dispatch('earrings/removeItem', id);
}

export const addItem = (store, {img_path,name, description, cost, id_material }) => {
  const { dispatch } = store;
  dispatch('earrings/addItem', { img_path,name, description, cost, id_material });
}

export const updateItem = (store, { id, img_path,name, description, cost, id_material }) => {
  const { dispatch } = store;
  dispatch('earrings/updateItem', { id, img_path,name, description, cost, id_material });
}

export const selectItemById = (store, id) => {
  const { getters } = store;
  return getters['earrings/itemsByKey'][id] || {};
}

