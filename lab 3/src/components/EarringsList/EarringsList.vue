<template>
  <div :class="$style.root">
    <Table
        :headers="[
        { value: 'id', text: 'ID' },
        { value: 'name', text: 'Название' },
        { value: 'img_path', text: 'Картинка' },
        { value: 'description', text: 'Описание' },
        { value: 'cost', text: 'Стоимость' },
        { value: 'material_name', text: 'Материал' },
        { value: 'control', text: 'Действие' },
      ]"
        :items="items"
    >
      <template v-slot:control="{ item }">
        <Btn @click="onClickEdit(item.id)" theme="info">Изменить</Btn>
        <Btn @click="onClickRemove(item.id)" theme="danger">Удалить</Btn>
      </template>

      <template v-slot:img_path="{ item }">
        <img :src="getImgUrl(item.img_path)" alt="Изображение" width="100px" height="100px">
      </template>
    </Table>

    <router-link :to="{ name: 'EarringsEdit' }">
      <Btn :class="$style.create" theme="info">Создать</Btn>
    </router-link>
  </div>
</template>

<script>
import { useStore } from 'vuex';
import { computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';

import { selectItems, removeItem, fetchItems } from '@/store/earrings/selectors';
import Table from '@/components/Table/Table';
import Btn from '@/components/Btn/Btn';
import { fetchMaterials, selectItemById } from '@/store/materials/selectors';

export default {
  name: 'EarringsList',
  components: {
    Table,
    Btn,
  },
  setup() {
    const store = useStore();
    const router = useRouter();

    onMounted(() => {
      fetchItems(store);
      fetchMaterials(store);
    });

    return {
      items: computed(() => {
        return selectItems(store).map(item => ({
          ...item,
          material_name: selectItemById(store, item.id_material)?.material_name || 'Неизвестно', // material_name вместо material
        }));
      }),
      onClickRemove: id => {
        const isConfirmRemove = confirm('Вы действительно хотите удалить запись?');
        if (isConfirmRemove) {
          removeItem(store, id);
        }
      },
      onClickEdit: id => {
        router.push({ name: 'EarringsEdit', params: { id } });
      },
      getImgUrl: imgPath => {
        if (!imgPath) return 'Изображение не найдено';
        try {
          return require(`@/assets/img/${imgPath}`);
        } catch (error) {
          console.error('Ошибка загрузки изображения:', error);
          return 'Изображение не найдено';
        }
      }
    };
  }
};
</script>

<style module lang="scss">
.root {
  .create {
    margin-top: 16px;
  }
}
</style>
