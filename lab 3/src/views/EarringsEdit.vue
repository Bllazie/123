<template>
  <Layout :title="id ? 'Редактирование записи' : 'Создание записи'">
    <EarringsForm @submit="onSubmit" :id="id"  />
  </Layout>
</template>

<script>
import { useStore } from 'vuex';

import { updateItem, addItem } from '@/store/earrings/selectors';
import EarringsForm from '@/components/EarringsForm/EarringsForm';
import Layout from '@/components/Layout/Layout';

export default {
  name: 'EarringsEdit',
  props: {
    id: String,
  },
  components: {
    Layout,
    EarringsForm,
  },
  setup() {
    const store = useStore();
    return {
      onSubmit: ({id, img_path, name, description, cost, id_material}) => {
        if (id) {
          updateItem(store, {id, img_path, name, description, cost, id_material});
        } else {
          // При создании новой записи id не передается
          addItem(store, {id,img_path, name, description, cost, id_material});
        }
      },
    };
  },
};
</script>
