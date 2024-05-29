import axios from 'axios';
export const fetchMaterials = async (store) => {
  try {
    // Отправляем GET-запрос на правильный URL
    const response = await axios.get('http://localhost/crud_rest/rest/materials/list.json');

    // Если запрос успешен, передаем полученные данные в хранилище через мутацию
    store.commit('materials/setItems', response.data);
  } catch (error) {
    // Если произошла ошибка, выводим ее в консоль
    console.error('Error fetching items:', error);
  }
};
export const selectItems = ( store ) => {
  const { getters } = store;
  return getters['materials/items']
}

export const removeItem = ( store, id ) => {
  const { dispatch } = store;
  dispatch('materials/removeItem', id);
}

export const addItem = ( store, { material_name } ) => {//
  const { dispatch } = store;
  dispatch('materials/addItem', { material_name });//
}

export const updateItem = ( store, { id, material_name } ) => {
  const { dispatch } = store;
  dispatch('materials/updateItem', { id, material_name });
}

export const selectItemById = (store, id) => {
  const { getters } = store;
  return getters['materials/itemsByKey'][id] || {};
}
