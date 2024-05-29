import axios from 'axios';

export const fetchItems = async (store) => {
  try {
    // Отправляем GET-запрос на правильный URL
    const response = await axios.get('http://localhost/crud_rest/rest/earrings/list.json');

    // Если запрос успешен, передаем полученные данные в хранилище через мутацию
    store.commit('earrings/setItems', response.data);
  } catch (error) {
    // Если произошла ошибка, выводим ее в консоль
    console.error('Error fetching items:', error);
  }
};


export const selectItems = (store) => {
  const { getters } = store;
  return getters['earrings/items']
}

export const removeItem = (store, id) => {
  const { dispatch } = store;
  dispatch('earrings/removeItem', id);
}

export const addItem = (store, {img_path, name, description, cost, id_material}) => {
  const { dispatch } = store;
  dispatch('earrings/addItem', { img_path, name, description, cost, id_material });
}

export const updateItem = (store, { id, img_path, name, description, cost, id_material }) => {
  const { dispatch } = store;
  dispatch('earrings/updateItem', { id, img_path, name, description, cost, id_material});
}

export const selectItemById = (store, id) => {
  const { getters } = store;
  return getters['earrings/itemsByKey'][id] || {};
}


export const selectItemsBystoreID = async (store, storeID) => {
  try {
    const response = await axios.get(`http://localhost/crud_rest/rest/earrings/SelectByID?material=${storeID}`);
    return response.data; // Возвращаем данные без коммита изменений в store
  } catch (error) {
    console.error('Error fetching items:', error);
    return []; // Возвращаем пустой массив в случае ошибки
  }
};

export const fetchItemsBystoreID = async (store, storeID) => {
  try {
    const items  = await selectItemsBystoreID(store, storeID);
    store.commit('earrings/setItemsBystoreID', items);
  } catch (error) {
    console.error('Error fetching items by store ID:', error);
  }
};
