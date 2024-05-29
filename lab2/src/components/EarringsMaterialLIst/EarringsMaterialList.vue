<template>
  <div :class="$style.root">
    <Table
        :headers="[
        {value: 'id', text: 'ID'},
        {value: 'name', text: 'Название'},
        {value: 'img_path', text: 'Картинка'},
        {value: 'description', text: 'Описание'},
        {value: 'cost', text: 'Стоимость'},
        {value: 'id_material', text: 'Материал'},
        {value: 'control', text: 'Действие'},
      ]"
        :items="items"
    >
      <template v-slot:control="{ item }">
        <Btn @click="onClickEdit(item.id)" theme="info">Изменить</Btn>
        <Btn @click="onClickRemove(item.id)" theme="danger">Удалить</Btn>
      </template>
      <template v-slot:img_path="{ item }">
        <img :src="require(`@/assets/img/${item.img_path}`)" alt="Изображение" style="max-width: 200px;" />
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
import {selectItemsByMaterialsId, removeItem, fetchItems } from '@/store/earrings/selectors';
import  {selectItemById } from '@/store/materials/selectors';//fetchMenus
import Table from '@/components/Table/Table';
import Btn from '@/components/Btn/Btn';

export default {
  name: 'EarringsMaterialPage',
  components: {
    Table,
    Btn,
  },
  setup() {
    const store = useStore();
    const router = useRouter();
    onMounted(() => {
      fetchItems(store);
    });

    const materialId = router.currentRoute.value.query.materialId;
    const items = computed(() => {
      const earrings = selectItemsByMaterialsId(store, materialId);
      return earrings.map(earring => {
        const material = selectItemById(store, earring.id_material);
        return { ...earring, id_material: material ? material.material_name : '' };
      });
    });

    const onClickRemove = id => {
      const isConfirmRemove = confirm('Вы действительно хотите удалить запись?')
      if (isConfirmRemove) {
        removeItem(store, id)
      }
    };

    const onClickEdit = id => {
      router.push({ name: 'EarringsEdit', params: { id } })
    };

    return {
      items,
      onClickRemove,
      onClickEdit
    };
  },
}
</script>

<style module lang="scss">
.root {
  .create {
    margin-top: 16px;
  }
}
</style>

