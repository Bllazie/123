<template>
  <div :class="$style.root">
    <Table
        :headers="[
        {value: 'id', text: 'ID'},
        {value: 'name', text: 'Название'},
        {value: 'img_path', text: 'Картинка'},
        {value: 'description', text: 'Описание'},
        {value: 'cost', text: 'Стоимость'},
        {value: 'material_name', text: 'Материал'},
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
import { removeItem, fetchItemsBystoreID } from '@/store/earrings/selectors';
import { fetchMaterials } from '@/store/materials/selectors';
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
      const storeID = router.currentRoute.value.query.storeID;
      if (storeID) {
        fetchMaterials(store);
        fetchItemsBystoreID(store, storeID);
      } else {
        console.error('Store ID is not defined in the query parameters');
      }
    });

    const items = computed(() => store.state.earrings.itemsBystoreID);
    // Удаление драгоценностей
    const onClickRemove = id => {
      const isConfirmRemove = confirm('Вы действительно хотите удалить запись?')
      if (isConfirmRemove) {
        removeItem(store, id)
      }
    };

    // Редактирование драгоценности
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

