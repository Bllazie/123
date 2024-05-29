export const fetchMaterials = ( store ) => {
  const { dispatch } = store;
  dispatch('materials/fetchMaterials');
};

export const selectItems = ( store ) => {
  const { getters } = store;
  return getters['materials/items']
}

export const removeItem = ( store, id ) => {
  const { dispatch } = store;
  dispatch('materials/removeItem', id);
}

export const addItem = ( store, { materials} ) => {
  const { dispatch } = store;
  dispatch('materials/addItem', { materials });
}

export const updateItem = ( store, { id, material  }) => {
  const { dispatch } = store;
  dispatch('materials/updateItem', { id, material });
}

export const selectItemById = (store, id) => {
  const { getters } = store;
  return getters['materials/itemsByKey'][id] || {};
}
