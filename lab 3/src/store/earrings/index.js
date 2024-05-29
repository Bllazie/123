import api from './api';

export default {
  namespaced: true,
  state: {
    items: [],
    itemsBystoreID: []
  },
  getters: {
    items: state => state.items,
    itemsByKey: state => state.items.reduce((res, cur) => {
      res[cur['id']] = cur;
      return res;
    }, {}),
  },
  mutations: {
    setItemsBystoreID: (state, items) => {
      state.itemsBystoreID = items;
    },

    setItems: (state, items) => {
      state.items = items;
    },
    setItem: (state, item) => {
      state.items.push(item);
    },
    removeItem: (state, idRemove) => {
      state.items = state.items.filter(({ id }) => id !== idRemove)
    },
    updateItem: (state, updateItem) => {
      const index = state.items.findIndex(item => +item.id === +updateItem.id);
      state.items[index] = updateItem;
    },

    itemsByID: (state, idItem) =>{
      state.items = state.items.filter(({ id_material }) => id_material !== idItem);
    }
  },
  actions: {
    fetchItems: async ({ commit }) => {
      try {
        const response = await api.earrings();
        const items = await response.json();
        commit('setItems', items);
      } catch (error) {
        console.error('Error fetching earrings:', error);
      }
    },
    removeItem: async ({ commit }, id) => {
      const idRemovedItem = await api.remove( id );
      commit('removeItem', idRemovedItem);

    },
    fetchItemsBystoreID: async ({ commit }, storeID) => {
      try {
        const items = await api.earringId(storeID);
        commit('setItemsBystoreID', items);
      } catch (error) {
        console.error('Error fetching items by store ID:', error);
      }
    },
    addItem: async ({ commit }, { id, img_path, name, description, cost, id_material}) => {//
      const item = await api.add({ id, img_path, name, description, cost, id_material})//
      commit('setItem', item)
    },
    updateItem: async ({ commit }, {id, img_path, name, description, cost, id_material }) => {//
      const item = await api.update({ id, img_path, name, description, cost, id_material });//
      commit('updateItem', item);
    }
  },
}
