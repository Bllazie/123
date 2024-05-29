import api from './api';

export default {
  namespaced: true,
  state: {
    items: [],
  },
  getters: {
    items: state => state.items,
    itemsByKey: state => state.items.reduce((res, cur) => {
      res[cur['id']] = cur;
      return res;
    }, {}),
  },
  mutations: {
    setItems: (state, items) => {
      state.items = items;
    },
    addItem: (state, item) => {
      state.items.push(item);
    },
    removeItem: (state, idRemove) => {
      state.items = state.items.filter(({ id }) => id !== idRemove);
    },
    updateItem: (state, updateItem) => {
      const index = state.items.findIndex(item => +item.id === +updateItem.id);
      state.items[index] = updateItem;
    }
  },
  actions: {
    fetchMaterials: async ({ commit }) => {
      try {
        const response = await api.materials();
      const items = await response.json();
      commit('setItems', items);}
      catch (error) {
        console.error('Error fetching groups:', error);
      }
    },
    removeItem: async ({ commit }, id) => {
      try {
        await api.remove(id);
        commit('removeItem', id);
      } catch (error) {
        console.error('Error removing materials:', error);
      }
    },
    addItem: async ({ commit }, { material_name}) => {
      try {
        const item = await api.add({ material_name });
        commit('addItem', item);
      } catch (error) {
        console.error('Error adding materials:', error);

      }
    },
    updateItem: async ({ commit }, { id, material_name}) => {
      try {const item = await api.update({ id, material_name});
      commit('updateItem', item);
      } catch (error) {
        console.error('Error updating group:', error);
      }
    }
  },
}
