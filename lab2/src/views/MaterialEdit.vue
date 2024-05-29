<template>
  <Layout :title="id ? 'Редактирование записи' : 'Создание записи'">
    <MaterialForm
        :id="id"
        @submit="onSubmit"
    />
  </Layout>
</template>

<script>
import { useStore } from 'vuex';

import { updateItem, addItem } from '@/store/materials/selectors';
import Layout from '@/components/Layout/Layout';
import MaterialForm from '@/components/MaterialForm/MaterialForm';

export default {
  name: 'MaterialEdit',
  props: {
    id: String,
  },
  components: {
    MaterialForm,
    Layout
  },
  setup() {
    const store = useStore();
    return {
      onSubmit: ({ id, material_name }) => id ?
          updateItem(store, { id, material_name }) :
          addItem(store, { material_name }),
    };
  }
}
</script>

